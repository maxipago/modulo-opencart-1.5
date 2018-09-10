<?php
/**
 * maxiPago!
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 */

/**
 * maxiPago! Payment Method
 *
 * @package    maxiPago!
 * @author     Bizcommerce
 * @copyright  Copyright (c) 2016 BizCommerce
 *
 * @property ModelPaymentMaxipago model_payment_maxipago
 * @property ModelCheckoutOrder model_checkout_order
 * @property Url url
 * @property Request request
 * @property Config config
 * @property DB db
 */

require_once(DIR_SYSTEM . 'library/maxipago/maxipago.php');
class ControllerPaymentMaxipago extends Controller
{
    const CC_BRANDS = array('VISA', 'MASTERCARD', 'AMEX', 'DINERS', 'ELO', 'DISCOVER', 'HIPERCARD', 'HIPER', 'JCB', 'AURA', 'CREDZ');
    const DC_BRANDS = array('VISA', 'MASTERCARD');
    const TEF_BANKS = array('17' => 'Bradesco', '18' => 'Itaú');

    const MAXIPAGO_CODE = 'maxipago';
    protected $_maxipago;

    private $error = array();

    protected $_generalFields = array(
        'status',
        'store_id',
        'consumer_key',
        'secret_key',
        'method_title',
        'street_number',
        'street_complement',
        'minimum_amount',
        'maximum_amount',
        'environment',
        'geo_zone_id',
        'sort_order',
        //CC
        'cc_enabled',
        'cc_order_reverse',
        'cc_max_installments',
        'cc_installments_without_interest',
        'cc_interest_type',
        'cc_processing_type',
        'cc_can_save',
        'cc_fraud_check',
        'cc_fraud_processor',
        'cc_clearsale_app',
        'cc_auto_capture',
        'cc_auto_void',
        'cc_3ds',
        'cc_3ds_processor',
        'cc_3ds_failure_action',
        //DC
        'dc_enabled',
        'dc_soft_descriptor',
        'dc_mpi_processor',
        'dc_failure_action',
        //REDEPAY
        'redepay_enabled',
        //TICKET
        'ticket_enabled',
        'ticket_days_to_expire',
        'ticket_instructions',
        'ticket_bank',
        //EFT
        'eft_enabled',
        //STATUSES
        'order_processing',
        'order_authorized',
        'order_approved',
        'order_refunded',
        'order_cancelled',
        //LOG
        'logging'
    );

    protected $_multiselectFields = array(
        'eft_banks'
    );

    protected $_ccBrands = array(
        'visa',
        'mastercard',
        'amex',
        'diners',
        'elo',
        'discover',
        'hipercard',
        'hiper',
        'jcb',
        'aura',
        'credz'
    );

    protected $_dcBrands = array(
        'visa',
        'mastercard'
    );

    protected $_numberFields = array(
        'interest_rate',
        'min_per_installments'
    );

    protected $_ticketBanks = array(
        '13' => 'Banco do Brasil',
        '12' => 'Bradesco',
        '16' => 'Caixa Economica Federal',
        '14' => 'HSBC',
        '11' => 'Itaú',
        '15' =>  'Santander'
    );

    protected $_eftBanks = array(
        '17' => 'Bradesco',
        '18' => 'Itaú',
    );

    /**
     * Create hooks and tables on installing the module
     */
    public function install()
    {
        $this->_createTables();
    }

    /**
     * Cretae tables on install module
     */
    protected function _createTables()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'maxipago_cc_token` (
              `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              `id_customer` INT(10) UNSIGNED NOT NULL ,
              `id_customer_maxipago` INT(10) UNSIGNED NOT NULL ,
              `brand` VARCHAR(255) NOT NULL, 
              `token` VARCHAR(255) NOT NULL ,
              `description` VARCHAR(255) NOT NULL ,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        $this->db->query($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'maxipago_transactions` (
              `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              `id_order` INT(10) UNSIGNED NOT NULL ,
              `boleto_url` VARCHAR(255) NULL ,
              `online_debit_url` VARCHAR(255) NULL,
              `authentication_url` VARCHAR(255) NULL,
              `method` VARCHAR(255) NOT NULL, 
              `request` TEXT NOT NULL ,
              `return` TEXT NOT NULL ,
              `response_message` VARCHAR(255) NOT NULL,
              `created_at` DATETIME,
              PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        $this->db->query($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `' . DB_PREFIX . 'maxipago_recurring_transactions` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, 
            `order_id` INT(10) UNSIGNED NOT NULL,
            `order_recurring_id` INT(10) UNSIGNED NOT NULL,
            `maxipago_order_id` VARCHAR(255) NOT NULL,
            `maxipago_status` VARCHAR(255) NOT NULL, 
            `request` TEXT NOT NULL,
            `response` TEXT NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        $this->db->query($sql);
    }

    /**
     * Remove hooks on uninstalling the module
     */
    public function uninstall()
    {
    }

    public function index()
    {
        $this->load->language('payment/maxipago');

        $this->document->setTitle($this->language->get('heading_title'));

        /* Load Models */
        $this->load->model('localisation/order_status');
        $this->load->model('localisation/geo_zone');
        $this->load->model('design/custom_field');
        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->_validate()) {
            $this->model_setting_setting->editSetting('maxipago', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('payment/maxipago', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        }

        if (isset($this->session->data['error'])) {
            $data['error'] = $this->session->data['error'];
            unset($this->session->data['error']);
        }

        $params = 'token=' . $this->session->data['token'] . '&mpKey=' . $this->config->get('maxipago_consumer_key');
        $data['sync_url'] = $this->url->link('payment/maxipago/syncronize', $params, 'SSL');

        $data['catalog_sync_url'] = $this->getCatalogUrl('synchronize');
        $data['catalog_success_url'] = $this->getCatalogUrl('success');
        $data['catalog_error_url'] = $this->getCatalogUrl('error');
        $data['catalog_notification_url'] = $this->getCatalogUrl('notification');

        $data = $this->_breadcrumbs($data);
        $data = $this->_errors($data);
        $data = $this->_translate($data);
        $data['link_custom_field'] = $this->url->link('design/custom_field', 'token=' . $this->session->data['token'], 'SSL');

        $data['entry_cc_processors_visa'] = $this->_processors();
        $data['entry_cc_processors_master'] = $this->_processors();
        $data['entry_cc_processors_amex'] = $this->_processors('amex');
        $data['entry_cc_processors_diners'] = $this->_processors('diners');
        $data['entry_cc_processors_elo'] = $this->_processors('elo');
        $data['entry_cc_processors_discover'] = $this->_processors('discover');
        $data['entry_cc_processors_hipercard'] = $this->_processors('hipercard');
        $data['entry_cc_processors_hiper'] = $this->_processors('hiper');
        $data['entry_cc_processors_jcb'] = $this->_processors('jcb');
        $data['entry_cc_processors_aura'] = $this->_processors('aura');
        $data['entry_cc_processors_credz'] = $this->_processors('credz');
        $data['entry_dc_processors_visa'] = $this->_processors();
        $data['entry_dc_processors_mastercard'] = $this->_processors();
        $data['entry_ticket_banks'] = $this->_ticketBanks;
        $data['entry_eft_banks_list'] = $this->_eftBanks;

        $data['action'] = $this->url->link('payment/maxipago', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'] . '&type=payment', true);

        //GENERAL FIELDS
        foreach ($this->_generalFields as $field) {
            if (isset($this->request->post['maxipago_' . $field])) {
                $data['maxipago_' . $field] = $this->request->post['maxipago_' . $field];
            } else {
                $data['maxipago_' . $field] = $this->config->get('maxipago_' . $field);
            }
        }

        foreach ($this->_multiselectFields as $field) {
            if (isset($this->request->post['maxipago_' . $field])) {
                $eft_banks = $this->request->post['maxipago_' . $field];
                $data['maxipago_' . $field] = ($eft_banks) ? $eft_banks : array();
            } else {
                $eft_banks = $this->config->get('maxipago_' . $field);
                $data['maxipago_' . $field] = ($eft_banks) ? $eft_banks : array();
            }
        }

        //NUMBER FIELDS
        foreach ($this->_numberFields as $field) {
            if (isset($this->request->post['maxipago_cc_' . $field])) {
                $interest_rate = str_replace(',', '.', $this->request->post['maxipago_cc_' . $field]);
                $data['maxipago_cc_' . $field] = $this->request->post['maxipago_cc_' . $field];
            } else {
                $data['maxipago_cc_' . $field] = $this->config->get('maxipago_cc_' . $field);
            }
        }

        //BRAND PROCESSORS
        foreach($this->_ccBrands as $brand) {
            if (isset($this->request->post['maxipago_' . $brand . '_processor'])) {
                $data['maxipago_' . $brand . '_processor'] = $this->request->post['maxipago_' . $brand . '_processor'];
            } else {
                $data['maxipago_' . $brand . '_processor'] = $this->config->get('maxipago_' . $brand . '_processor');
            }
        }

        //DEBIT CARD PROCESSORS
        foreach($this->_dcBrands as $brand) {
            if (isset($this->request->post['maxipago_dc_' . $brand . '_processor'])) {
                $data['maxipago_dc_' . $brand . '_processor'] = $this->request->post['maxipago_dc_' . $brand . '_processor'];
            }else {
                $data['maxipago_dc_' . $brand . '_processor'] = $this->config->get('maxipago_dc_' . $brand . '_processor');
            }
        }

        /* Custom Field */
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $data['custom_fields'] = $this->model_design_custom_field->getCustomFields();
        $data['column_left'] = null;
        $this->data = $data;

        $this->template = 'payment/maxipago.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    private function getCatalogUrl($function_name)
    {
        $use_ssl = $this->config->get('config_secure');
        $catalog_base_url = new Url(HTTP_CATALOG, $use_ssl ? HTTPS_CATALOG : HTTP_CATALOG);

        $store_key = $this->config->get('maxipago_consumer_key');
        return $catalog_base_url->link('payment/maxipago/' . $function_name, '&mpKey=' . $store_key, $use_ssl);
    }

    /**
     * Sync maxipago Orders from the last 15 days
     */
    public function syncronize()
    {
        $success = array();
        $ordersUpdated = array();

        try {
            $this->load->language('payment/maxipago');
            $this->load->model('payment/maxipago');

            $total = 0;
            $consumerKey = isset($this->request->get['mpKey']) ? $this->request->get['mpKey'] : null;

            if (trim($consumerKey) && $consumerKey == $this->config->get('maxipago_consumer_key')) {

                $orderId = isset($this->request->get['orderId']) ? $this->request->get['orderId'] : null;

                $searchStatues = array(
                    '"BOLETO ISSUED"',
                    '"BOLETO VIEWED"',
                    '"PENDING"',
                    '"PENDING CONFIRMATION"',
                    '"AUTHORIZED"',
                    '"CAPTURED"',
                    '"REVIEW"',
                    '"FRAUD REVIEW"',
                );

                $date = new DateTime('-15 DAYS'); // first argument uses strtotime parsing
                $fromDate = $date->format('Y-m-d 00:00:00');

                $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_transactions
                    WHERE `created_at` > "' . $fromDate . '" 
                    ';

                if ($orderId) {
                    $sql .= 'AND `id_order` = "' . $orderId . '"';
                }

                $query = $this->db->query($sql);
                if ($query->num_rows) {

                    foreach ($query->rows as $transaction) {
                        // If the transaction is authorized ...
                        if($transaction['response_message'] == 'AUTHORIZED')
                        {
                            $approved_status = $this->config->get('maxipago_order_approved');
                            // .. we must look the order ...
                            $order = $this->db->query('SELECT * FROM `' . DB_PREFIX . 'order` WHERE `order_id` = ' . $transaction['id_order'])->row;

                            if($order)
                            {
                                // .. to see if the order status ...
                                $order_status = $order['order_status_id'];
                                // ... was manually changed to approved.
                                if($approved_status == $order_status)
                                {
                                    // If so, we must capture the order.
                                    $this->model_payment_maxipago->capture($order);
                                }
                            }
                        }


                        $orderUpadted = $this->model_payment_maxipago->sync($transaction);
                        if ($orderUpadted) {
                            $total++;
                            array_push($ordersUpdated, $orderUpadted);
                        }
                    }

                }

                $total += $this->synchronizeRefundOrders();
            }

            if ($total) {
                //Total de pedidos atualizados
                array_push($success, sprintf($this->language->get('text_success_sync'), $total));
                //Pedidos atualizados
                array_push($success, implode(', ', $ordersUpdated));
            } else {
                $success = $this->language->get('text_success_no_sync');
            }

            $this->session->data['success'] = $success;

        } catch (Exception $e) {
            $this->session->data['error'] = $this->language->get('text_error_sync') . '(' . $e->getMessage() . ')';
            $this->log('Error syncing order: ' . $e->getMessage());
        }

        //Gera o link do boleto da maxiPago! e coloca nos comentários do pedido
        $this->redirect($this->url->link('payment/maxipago', 'token=' . $this->session->data['token'], 'SSL'));
    }

    protected function synchronizeRefundOrders()
    {
        $refundCount = 0;
        $minimum_creation_date = (new DateTime('-15 DAYS'))->format('Y-m-d 00:00:00');
        $refund_order_status_id = $this->config->get('maxipago_order_refunded');

        $sql = 'SELECT * FROM `' . DB_PREFIX . 'order`' .
            'WHERE `date_added` > "' . $minimum_creation_date . '" ' .
            'AND `payment_code` = "maxipago" ' .
            'AND `order_status_id` = ' . $refund_order_status_id;

        $possibleRefundableOrders = $this->db->query($sql)->rows;

        foreach($possibleRefundableOrders as $possibleRefundableOrder)
        {
            $orderTransactionSql = 'SELECT * FROM `' . DB_PREFIX . 'maxipago_transactions` ' .
                'WHERE `id_order` = ' . $possibleRefundableOrder['order_id'] .
                ' AND `method` = "card"';

            $transactionQuery = $this->db->query($orderTransactionSql);

            if($transactionQuery->num_rows > 0)
            {
                $transaction = $transactionQuery->row;

                if($transaction['response_message'] == 'REFUNDED' || $transaction['response_message'] == 'VOIDED')
                    continue;

                if($this->model_payment_maxipago->reverse($possibleRefundableOrder))
                    $refundCount++;
            }
        }

        return $refundCount;
    }

    /**
     * Reverse a cancelled order
     *
     * @param $route
     * @param $orders
     */
    public function reverse($route, $orders)
    {
        if ($this->config->get('maxipago_cc_order_reverse')) {
            $this->load->language('payment/maxipago');
            $this->load->model('payment/maxipago');

            try {
                $query = $this->db->query("
                  SELECT * 
                  FROM `" . DB_PREFIX . "order` AS o
                  JOIN " . DB_PREFIX . "maxipago_transactions  as mt ON o.order_id = mt.id_order
                  WHERE o.payment_code = '" . self::MAXIPAGO_CODE . "' 
                  AND o.order_id IN (" . implode(',', $orders) . ");
                ");
                if ($query->num_rows) {
                    foreach ($query->rows as $order_info) {
                        $this->model_payment_maxipago->reverse($order_info);
                    }
                }

            } catch (Exception $e) {
                $this->session->data['error'] = $e->getMessage();
            }
        }
    }

    /**
     * Validate Admin Data
     * @return bool
     */
    protected function _validate()
    {
        if (!$this->user->hasPermission('modify', 'payment/maxipago')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $street_number = isset($this->request->post['maxipago_street_number']) ? $this->request->post['maxipago_street_number'] : null;
        if (!$street_number) {
            $this->error['street_number'] = $this->language->get('error_street_number');
        }

        $street_complement = isset($this->request->post['maxipago_street_number']) ? $this->request->post['maxipago_street_number'] : null;
        if (!$street_complement) {
            $this->error['street_complement'] = $this->language->get('error_street_complement');
        }

        if (!$this->request->post['maxipago_consumer_key']) {
            $this->error['consumer'] = $this->language->get('error_consumer');
        }

        if (!$this->request->post['maxipago_secret_key']) {
            $this->error['secret'] = $this->language->get('error_secret');
        }

        return !$this->error;
    }

    /**
     * Errors
     * @param $data
     * @return mixed
     */
    protected function _errors($data)
    {
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        //Errors
        if (isset($this->error['consumer'])) {
            $data['error_store_id'] = $this->error['consumer'];
        } else {
            $data['error_store_id'] = '';
        }

        if (isset($this->error['consumer'])) {
            $data['error_consumer_key'] = $this->error['consumer'];
        } else {
            $data['error_consumer_key'] = '';
        }

        if (isset($this->error['secret'])) {
            $data['error_secret_key'] = $this->error['secret'];
        } else {
            $data['error_secret_key'] = '';
        }

        if (isset($this->error['street_number'])) {
            $data['error_street_number'] = $this->error['street_number'];
        } else {
            $data['error_street_number'] = '';
        }

        if (isset($this->error['street_complement'])) {
            $data['error_street_complement'] = $this->error['street_complement'];
        } else {
            $data['error_street_complement'] = '';
        }

        return $data;
    }

    /**
     * Breadcrumbs to admin page
     * @param $data
     * @return mixed
     */
    protected function _breadcrumbs($data)
    {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/maxipago', 'token=' . $this->session->data['token'], 'SSL')
        );

        return $data;
    }

    /**
     * Credit Card processors
     * @param string $type
     * @return array
     */
    protected function _processors($type = 'all')
    {
        $processors = array(
            '1' => 'Simulador de Teste',
            '2' => 'Redecard',
            '3' => 'GetNet',
            '4' => 'Cielo',
            '5' => 'e.Rede',
            '6' => 'Elavon',
            '9' => 'Stone',
            '10' => 'Bin'
        );
        $types = array(
            'all' => array('1', '2', '3', '4', '5', '6', '9', '10'),
            'amex' => array('1', '4', '5'),
            'diners' => array('1', '2', '4', '5', '6'),
            'elo' => array('1', '4', '5', '10'),
            'discover' => array('1', '4', '6'),
            'hipercard' => array('1', '2', '4', '5'),
            'hiper' => array('1', '2', '5'),
            'jcb' => array('1', '2', '4', '5'),
            'aura' => array('1', '4'),
            'credz' => array('1', '2', '5'),
        );

        $processorKeys = array_keys($processors);
        foreach ($processors as $typeId => $typeName) {
            if (!in_array($typeId, $types[$type])) {
                unset($processors[$typeId]);
            }
        }

        $processors = array('' => 'Desabilitado') + $processors;
        return $processors;
    }

    /**
     * Translate items
     * @param $data
     * @return array
     */
    protected function _translate($data)
    {
        $textFields = array(
            'text_edit',
            'text_enabled',
            'text_disabled',
            'text_all_zones',
            'text_none',
            'text_yes',
            'text_no',
            'text_sync',
            'text_select',
            'text_cron',
            'text_kount',
            'text_clearsale',
            'text_test',
            'text_production',
            'text_decline',
            'text_continue',

            'text_notification',
            'text_notification_configure',
            'text_url_success',
            'text_url_error',
            'text_url_notification',

            'tab_general',
            'tab_order_cc',
            'tab_order_dc',
            'tab_order_redepay',
            'tab_order_ticket',
            'tab_order_eft',
            'tab_order_status',

            'entry_store_id',
            'help_store_id',

            'entry_consumer_key',
            'help_consumer_key',

            'entry_secret_key',
            'help_secret_key',

            'entry_method_title',
            'help_method_title',

            'entry_street_number',
            'help_street_number',

            'entry_street_complement',
            'help_street_complement',

            'text_custom_field',

            'entry_minimum_amount',
            'help_minimum_amount',

            'entry_maximum_amount',
            'help_maximum_amount',

            'entry_logging',

            //CC
            'entry_cc_enabled',

            'entry_cc_order_reverse',
            'help_cc_order_reverse',

            'entry_cc_max_installments',
            'entry_cc_installments_without_interest',

            'entry_cc_interest_type',
            'entry_simple',
            'entry_compound',
            'entry_price',

            'entry_cc_interest_rate',
            'help_cc_interest_rate',

            'entry_cc_min_per_installments',
            'help_cc_min_per_installments',

            'entry_cc_processing_type',
            'entry_cc_auth',
            'entry_cc_sale',

            'entry_cc_can_save',
            'entry_cc_fraud_check',
            'entry_cc_fraud_processor',
            'entry_cc_clearsale_app',
            'entry_cc_auto_capture',
            'entry_cc_auto_void',
            'entry_cc_3ds',
            'entry_cc_3ds_processor',
            'entry_cc_3ds_failure_action',
            'entry_cc_processors',

            //DC
            'entry_dc_enabled',
            'entry_dc_processors',
            'entry_dc_soft_descriptor',
            'entry_dc_mpi_processor',
            'entry_dc_mpi_processor_test',
            'entry_dc_mpi_processor_deployment',
            'entry_dc_failure_action',
            'entry_dc_failure_action_decline',
            'entry_dc_failure_action_continue',

            //REDEPAY
            'entry_redepay_enabled',

            //TICKET
            'entry_ticket_enabled',
            'entry_ticket_days_to_expire',
            'entry_ticket_instructions',
            'entry_ticket_bank',
            'entry_ticket_bank',

            //EFT
            'entry_eft_enabled',
            'entry_eft_banks',

            //STATUS
            'entry_order_processing',
            'help_order_processing',
            'entry_order_authorized',
            'help_order_authorized',
            'entry_order_approved',
            'help_order_approved',
            'entry_order_refunded',
            'help_order_refunded',
            'entry_order_cancelled',
            'help_order_cancelled',

            'entry_environment',
            'help_environment',
            'entry_test',
            'entry_production',

            'entry_geo_zone',
            'entry_status',
            'entry_sort_order',

            'button_save',
            'button_cancel',
            'button_sync',
        );

        foreach ($textFields as $field) {
            $data[$field] = $this->language->get($field);
        }

        return $data;
    }

    /**
     * @param $data
     * @param int $step
     */
    public function log($data, $step = 4)
    {
        if ($this->config->get('maxipago_logging')) {
            $backtrace = debug_backtrace();
            $log = new Log('maxipago.log');

            $data = preg_replace('/<number>(.*)<\/number>/m', '<number>*****</number>', $data);
            $data = preg_replace('/<cvvNumber>(.*)<\/cvvNumber>/m', '<cvvNumber>***</cvvNumber>', $data);
            $data = preg_replace('/<token>(.*)<\/token>/m', '<token>***</token>', $data);

            $log->write('(' . $backtrace[$step]['class'] . '::' . $backtrace[$step]['function'] . ') - ' . $data);
        }
    }

}
