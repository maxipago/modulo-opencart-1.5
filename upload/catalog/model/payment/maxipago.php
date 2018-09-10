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
 * @property ModelCheckoutOrder model_checkout_order
 */

require_once(DIR_SYSTEM . 'library/maxipago/maxipago.php');
class ModelPaymentMaxipago extends Model
{
    protected $_maxipago;

    const DEFAULT_IP = '127.0.0.1';
    const MAXIPAGO_CODE = 'maxipago';

    protected $_countryCodes = array(
        'AD' => '376',
        'AE' => '971',
        'AF' => '93',
        'AG' => '1268',
        'AI' => '1264',
        'AL' => '355',
        'AM' => '374',
        'AN' => '599',
        'AO' => '244',
        'AQ' => '672',
        'AR' => '54',
        'AS' => '1684',
        'AT' => '43',
        'AU' => '61',
        'AW' => '297',
        'AZ' => '994',
        'BA' => '387',
        'BB' => '1246',
        'BD' => '880',
        'BE' => '32',
        'BF' => '226',
        'BG' => '359',
        'BH' => '973',
        'BI' => '257',
        'BJ' => '229',
        'BL' => '590',
        'BM' => '1441',
        'BN' => '673',
        'BO' => '591',
        'BR' => '55',
        'BS' => '1242',
        'BT' => '975',
        'BW' => '267',
        'BY' => '375',
        'BZ' => '501',
        'CA' => '1',
        'CC' => '61',
        'CD' => '243',
        'CF' => '236',
        'CG' => '242',
        'CH' => '41',
        'CI' => '225',
        'CK' => '682',
        'CL' => '56',
        'CM' => '237',
        'CN' => '86',
        'CO' => '57',
        'CR' => '506',
        'CU' => '53',
        'CV' => '238',
        'CX' => '61',
        'CY' => '357',
        'CZ' => '420',
        'DE' => '49',
        'DJ' => '253',
        'DK' => '45',
        'DM' => '1767',
        'DO' => '1809',
        'DZ' => '213',
        'EC' => '593',
        'EE' => '372',
        'EG' => '20',
        'ER' => '291',
        'ES' => '34',
        'ET' => '251',
        'FI' => '358',
        'FJ' => '679',
        'FK' => '500',
        'FM' => '691',
        'FO' => '298',
        'FR' => '33',
        'GA' => '241',
        'GB' => '44',
        'GD' => '1473',
        'GE' => '995',
        'GH' => '233',
        'GI' => '350',
        'GL' => '299',
        'GM' => '220',
        'GN' => '224',
        'GQ' => '240',
        'GR' => '30',
        'GT' => '502',
        'GU' => '1671',
        'GW' => '245',
        'GY' => '592',
        'HK' => '852',
        'HN' => '504',
        'HR' => '385',
        'HT' => '509',
        'HU' => '36',
        'ID' => '62',
        'IE' => '353',
        'IL' => '972',
        'IM' => '44',
        'IN' => '91',
        'IQ' => '964',
        'IR' => '98',
        'IS' => '354',
        'IT' => '39',
        'JM' => '1876',
        'JO' => '962',
        'JP' => '81',
        'KE' => '254',
        'KG' => '996',
        'KH' => '855',
        'KI' => '686',
        'KM' => '269',
        'KN' => '1869',
        'KP' => '850',
        'KR' => '82',
        'KW' => '965',
        'KY' => '1345',
        'KZ' => '7',
        'LA' => '856',
        'LB' => '961',
        'LC' => '1758',
        'LI' => '423',
        'LK' => '94',
        'LR' => '231',
        'LS' => '266',
        'LT' => '370',
        'LU' => '352',
        'LV' => '371',
        'LY' => '218',
        'MA' => '212',
        'MC' => '377',
        'MD' => '373',
        'ME' => '382',
        'MF' => '1599',
        'MG' => '261',
        'MH' => '692',
        'MK' => '389',
        'ML' => '223',
        'MM' => '95',
        'MN' => '976',
        'MO' => '853',
        'MP' => '1670',
        'MR' => '222',
        'MS' => '1664',
        'MT' => '356',
        'MU' => '230',
        'MV' => '960',
        'MW' => '265',
        'MX' => '52',
        'MY' => '60',
        'MZ' => '258',
        'NA' => '264',
        'NC' => '687',
        'NE' => '227',
        'NG' => '234',
        'NI' => '505',
        'NL' => '31',
        'NO' => '47',
        'NP' => '977',
        'NR' => '674',
        'NU' => '683',
        'NZ' => '64',
        'OM' => '968',
        'PA' => '507',
        'PE' => '51',
        'PF' => '689',
        'PG' => '675',
        'PH' => '63',
        'PK' => '92',
        'PL' => '48',
        'PM' => '508',
        'PN' => '870',
        'PR' => '1',
        'PT' => '351',
        'PW' => '680',
        'PY' => '595',
        'QA' => '974',
        'RO' => '40',
        'RS' => '381',
        'RU' => '7',
        'RW' => '250',
        'SA' => '966',
        'SB' => '677',
        'SC' => '248',
        'SD' => '249',
        'SE' => '46',
        'SG' => '65',
        'SH' => '290',
        'SI' => '386',
        'SK' => '421',
        'SL' => '232',
        'SM' => '378',
        'SN' => '221',
        'SO' => '252',
        'SR' => '597',
        'ST' => '239',
        'SV' => '503',
        'SY' => '963',
        'SZ' => '268',
        'TC' => '1649',
        'TD' => '235',
        'TG' => '228',
        'TH' => '66',
        'TJ' => '992',
        'TK' => '690',
        'TL' => '670',
        'TM' => '993',
        'TN' => '216',
        'TO' => '676',
        'TR' => '90',
        'TT' => '1868',
        'TV' => '688',
        'TW' => '886',
        'TZ' => '255',
        'UA' => '380',
        'UG' => '256',
        'US' => '1',
        'UY' => '598',
        'UZ' => '998',
        'VA' => '39',
        'VC' => '1784',
        'VE' => '58',
        'VG' => '1284',
        'VI' => '1340',
        'VN' => '84',
        'VU' => '678',
        'WF' => '681',
        'WS' => '685',
        'XK' => '381',
        'YE' => '967',
        'YT' => '262',
        'ZA' => '27',
        'ZM' => '260',
        'ZW' => '263'
    );

    protected $_responseCodes = array(
        '0' => 'Pagamento Aprovado',
        '1' => 'Pagamento Reprovado',
        '2' => 'Pagamento Reprovado',
        '5' => 'Pagamento em análise',
        '1022' => 'Ocorreu um erro com a finalizadora, entre em contato com nossa equipe',
        '1024' => 'Erros, dados enviados inválidos, entre em contato com nossa equipe',
        '1025' => 'Erro nas credenciais de envio, entre em contato com nossa equipe',
        '2048' => 'Erro interno, entre em contato com nossa equipe',
        '4097' => 'Erro de tempo de execução, entre em contato com nossa equipe'
    );

    protected $_transactionStates = array(
        '1' => 'In Progress',
        '3' => 'Captured',
        '6' => 'Authorized',
        '7' => 'Declined',
        '9' => 'Voided',
        '10' => 'Paid',
        '22' => 'Boleto Issued',
        '34' => 'Boleto Viewed',
        '35' => 'Boleto Underpaid',
        '36' => 'Boleto Overpaid',

        '4' => 'Pending Capture',
        '5' => 'Pending Authorization',
        '8' => 'Reversed',
        '11' => 'Pending Confirmation',
        '12' => 'Pending Review (check with Support)',
        '13' => 'Pending Reversion',
        '14' => 'Pending Capture (retrial)',
        '16' => 'Pending Reversal',
        '18' => 'Pending Void',
        '19' => 'Pending Void (retrial)',
        '29' => 'Pending Authentication',
        '30' => 'Authenticated',
        '31' => 'Pending Reversal (retrial)',
        '32' => 'Authentication in progress',
        '33' => 'Submitted Authentication',
        '38' => 'File submission pending Reversal',
        '44' => 'Fraud Approved',
        '45' => 'Fraud Declined',
        '46' => 'Fraud Review'
    );

    /**
     * maxiPago! lib Object
     * @return MaxiPago
     */
    public function getMaxipago()
    {
        if (!$this->_maxipago) {
            $merchantId = $this->config->get('maxipago_store_id');
            $sellerKey = $this->config->get('maxipago_consumer_key');
            if ($merchantId && $sellerKey) {
                $environment = ($this->config->get('maxipago_environment') == 'test') ? 'TEST' : 'LIVE';
                $this->_maxipago = new maxiPagoPayment();
                $this->_maxipago->setCredentials($merchantId, $sellerKey);
                $this->_maxipago->setEnvironment($environment);
            }
        }

        return $this->_maxipago;

    }

    public function recurringPayments() 
    {
        $recurring_products = $this->cart->getRecurringProducts();

        foreach($recurring_products as $recurring_product)
        {
            $has_trial = $recurring_product['recurring_trial'] == "1";
            $trial_is_paid = ((float) $recurring_product['recurring_trial_price']) > 0;

            /*
                * maxiPago! doesn't support recurring payments with paid trials
                */
            if($has_trial && $trial_is_paid)
                return false;
        }

        return true;
    }

    public function getMethod($address, $total)
    {
        $this->load->language('payment/maxipago');

        $query = $this->db->query("
          SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone 
          WHERE geo_zone_id = '" . (int)$this->config->get('maxipago_geo_zone_id') . "' 
          AND country_id = '" . (int)$address['country_id'] . "' 
          AND (
            zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0'
          )"
        );

        if ($this->config->get('maxipago_maximum_amount') > 0 && $this->config->get('maxipago_maximum_amount') <= $total) {
            $status = false;
        } elseif ($this->config->get('maxipago_minimum_amount') > 0 && $this->config->get('maxipago_minimum_amount') > $total) {
            $status = false;
        } elseif (!$this->config->get('maxipago_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();
        if ($status) {
            $method_data = array(
                'code' => self::MAXIPAGO_CODE,
                'title' => ($this->config->get(self::MAXIPAGO_CODE . '_method_title')) ? $this->config->get(self::MAXIPAGO_CODE . '_method_title') : $this->language->get('text_title'),
                'terms' => '',
                'sort_order' => $this->config->get('maxipago_sort_order')
            );
        }

        return $method_data;
    }

    /**
     * Remove the Credit Card frm maxiPago! Account and remove from the store Account
     *
     * @param $ccSaved
     * @return bool
     */
    public function deleteCC($ccSaved)
    {
        try {
            $data = array(
                'command' => 'delete-card-onfile',
                'customerId' => $ccSaved['id_customer'],
                'token' => $ccSaved['token']
            );

            $this->getMaxipago()->deleteCreditCard($data);
            $response = $this->getMaxipago()->response;
            $this->_saveTransaction('remove_card', $data, $response, null, false);

            $sql = 'DELETE FROM `' . DB_PREFIX . 'maxipago_cc_token` WHERE `id` = \'' . $ccSaved['id'] . '\';';
            $this->db->query($sql);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Send the ticket Payment method do maxiPago!
     *
     * @param $order_info
     * @return boolean
     */
    public function ticketMethod($order_info)
    {
        //Language
        $this->language->load('payment/maxipago');
        $response = null;

        //Boleto
        $methodEnabled = $this->config->get('maxipago_ticket_enabled');
        if ($methodEnabled) {

            //Order Data
            $totalOrder = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);

            $shippingTotal = $this->getOrderShippingValue($order_info['order_id']);
            $shippingTotal = number_format($shippingTotal, 2, '.', '');

            $orderId   = $this->session->data['order_id'];
            $ipAddress = $this->validateIP($order_info['ip']);
            $address = $this->_getAddress($order_info);
            $billingAddress = $address['billing'];
            $shippingAddress = $address['shipping'];
            $customerId = $order_info['customer_id'];

            $cpf = $this->getPost('ticket_cpf');
            $environment = $this->config->get('maxipago_environment');

            $dayToExpire = (int) $this->config->get('maxipago_ticket_days_to_expire');
            $instructions = $this->config->get('maxipago_ticket_instructions');

            $date = new DateTime();
            $date->modify('+' . $dayToExpire . ' days');
            $expirationDate = $date->format('Y-m-d');

            $boletoBank = ($environment == 'test') ? 12 : $this->config->get('maxipago_ticket_bank');

            $data = array(
                'referenceNum' => $orderId, //Order ID
                'processorID' => $boletoBank, //Bank Number
                'ipAddress' => $ipAddress,
                'chargeTotal' => $totalOrder,
                'shippingTotal' => $shippingTotal,
                'expirationDate' => $expirationDate,
                'customerIdExt' => $cpf,
                'number' => $orderId, //Our Number
                'instructions' => $instructions, //Instructions,
                'phone' => $billingAddress['telephone'],
                'billingId' => ($customerId) ? $customerId : $order_info['email'],
                'billingName' => $billingAddress['firstname'] . ' ' . $billingAddress['lastname'],
                'billingAddress' => $billingAddress['address1'],
                'billingAddress2' => $billingAddress['address2'],
                'billingCity' => $billingAddress['city'],
                'billingState' => $billingAddress['state'],
                'billingPostalCode' => $billingAddress['postcode'],
                'billingPhone' => $billingAddress['telephone'],
                'billingEmail' => $order_info['email'],
                'shippingId' => ($customerId) ? $customerId : $order_info['email'],
                'shippingName' => $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'],
                'shippingAddress' => $shippingAddress['address1'],
                'shippingAddress2' => $shippingAddress['address2'],
                'shippingCity' => $shippingAddress['city'],
                'shippingState' => $shippingAddress['state'],
                'shippingPostalCode' => $shippingAddress['postcode'],
                'shippingPhone' => $shippingAddress['telephone'],
                'shippingEmail' => $order_info['email'],
                'bname' => $order_info['firstname'] . ' ' . $order_info['lastname'],
                'baddress' => $billingAddress['address1'],
                'baddress2' => $billingAddress['address2'],
                'bcity' => $billingAddress['city'],
                'bstate' => $billingAddress['state'],
                'bpostalcode' => $billingAddress['postcode'],
                'bcountry' => $billingAddress['country'],
                'bemail' => $order_info['email'],
            );

            $this->getMaxipago()->boletoSale($data);
            $response = $this->getMaxipago()->response;

            $this->log($this->getMaxipago()->xmlRequest);
            $this->log($this->getMaxipago()->xmlResponse);

            $boletoUrl = isset($response['boletoUrl']) ? $response['boletoUrl'] : null;
            $this->_saveTransaction('ticket', $data, $response, $boletoUrl);

        }
        return $response;

    }

    /**
     * Send the payment method Credit Card to maxiPago!
     *
     * @param $order_info
     * @return boolean
     */
    public function cardMethod($order_info)
    {
        $methodEnabled = $this->config->get('maxipago_cc_enabled');
        $response = null;

        if ($methodEnabled) {

            //Order Data
            $totalOrder = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
            $order_id = $this->session->data['order_id'];

            $softDescriptor = $this->config->get('maxipago_cc_soft_descriptor');
            $processingType = $this->config->get('maxipago_cc_processing_type'); //auth || sale

            $fraudCheck = ($this->config->get('maxipago_cc_fraud_check')) ? 'Y' : 'N';
            $fraudCheck = $processingType != 'sale' ? $fraudCheck : 'N';

            $maxWithoutInterest = (int) $this->config->get('maxipago_cc_installments_without_interest');
            $interestRate = $this->config->get('maxipago_cc_interest_rate');
            $hasInterest = 'N';

            $customerId = $order_info['customer_id'];
            $firstname = $order_info['firstname'];
            $lastname = $order_info['lastname'];

            $ccBrand = $this->getPost('cc_brand');
            $ccNumber = $this->getPost('cc_number');
            $ccOwner = $this->getPost('cc_owner');
            $ccExpMonth = $this->getPost('cc_expire_date_month');
            $ccExpYear = $this->getPost('cc_expire_date_year');
            $ccCvv2 = $this->getPost('cc_cvv2');
            $ccInstallments = $this->getPost('cc_installments');

            $ipAddress = isset($_SERVER['REMOTE_ADDR']) ? $this->validateIP($_SERVER['REMOTE_ADDR']) : self::DEFAULT_IP;
            $address = $this->_getAddress($order_info);
            $order_data = $this->getOrderData();

            if ($interestRate && $ccInstallments > $maxWithoutInterest) {
                $hasInterest = 'Y';
                $totalOrder = $this->getTotalByInstallments($totalOrder, $ccInstallments, $interestRate);
            }

            $shippingTotal = $this->getOrderShippingValue($order_id);
            $shippingTotal = number_format($shippingTotal, 2, '.', '');

            $ccSavedCard = $this->getPost('cc_saved_card');

            if ($ccSavedCard) {
                $ccCvvSaved = $this->getPost('cc_cvv2_saved');

                $sql = 'SELECT *
                        FROM ' . DB_PREFIX . 'maxipago_cc_token
                        WHERE `id_customer` = \'' . $customerId . '\'
                        AND `description` = \'' . $ccSavedCard . '\'
                        LIMIT 1; ';
                $maxipagoToken = $this->db->query($sql)->row;

                $processorID =  $this->config->get('maxipago_' . $maxipagoToken['brand'] . '_processor');

                $data = array(
                    'customerId' => $maxipagoToken['id_customer_maxipago'],
                    'token' => $maxipagoToken['token'],
                    'cvvNumber' => $ccCvvSaved,
                    'referenceNum' => $order_id, //Order ID
                    'processorID' => $processorID, //Processor
                    'ipAddress' => $ipAddress,
                    'fraudCheck' => 'N',
                    'currencyCode' => $order_info['currency_code'],
                    'chargeTotal' => $totalOrder,
                    'shippingTotal' => $shippingTotal,
                    'numberOfInstallments' => $ccInstallments,
                    'chargeInterest' => $hasInterest,
                    'phone' => $address['billing']['telephone']
                );

            } else {

                $processorID =  $this->config->get('maxipago_' . $ccBrand . '_processor');

                $data = array(
                    'referenceNum' => $order_id, //Order ID
                    'processorID' => $processorID, //Processor
                    'ipAddress' => $ipAddress,
                    'fraudCheck' => $fraudCheck,
                    'number' => $ccNumber,
                    'expMonth' => $ccExpMonth,
                    'expYear' => $ccExpYear,
                    'cvvNumber' => $ccCvv2,
                    'currencyCode' => $order_info['currency_code'],
                    'chargeTotal' => $totalOrder,
                    'shippingTotal' => $shippingTotal,
                    'numberOfInstallments' => $ccInstallments,
                    'chargeInterest' => $hasInterest,
                    'phone' => $address['billing']['telephone']
                );

                $ccSaveCard = $this->getPost('cc_save_card');
                if ($ccSaveCard) {
                    $this->saveCard($order_info);
                }
            }

            $addressDataId = ($customerId) ? $customerId : $order_info['email'];
            $orderDataDistrict = isset($order_info['district']) ? $order_info['district'] : 'N/A';
            $orderDataEmail = $order_info['email'];
            $orderDataBirthDate = isset($order_info['birthdate']) ? $order_info['birthdate'] : '1990-01-01';

            $billingAddress = $address['billing'];
            $shippingAddress = $address['shipping'];

            $address_data = array(
                'billingId' => $addressDataId,
                'billingName' => $billingAddress['firstname'] . ' ' . $billingAddress['lastname'],
                'billingAddress' => $billingAddress['address1'],
                'billingAddress2' => $billingAddress['address2'],
                'billingDistrict' =>  $orderDataDistrict,
                'billingCity' => $billingAddress['city'],
                'billingCountry' => $billingAddress['country'],
                'billingState' => $billingAddress['state'],
                'billingPostalCode' => $billingAddress['postcode'],
                'billingPhone' => $billingAddress['telephone'],
                'billingEmail' => $orderDataEmail,
                'billingBirthDate' => $orderDataBirthDate,

                'shippingId' => $addressDataId,
                'shippingName' => $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'],
                'shippingAddress' => $shippingAddress['address1'],
                'shippingAddress2' => $shippingAddress['address2'],
                'shippingDistrict' => $orderDataDistrict,
                'shippingCity' => $shippingAddress['city'],
                'shippingCountry' => $shippingAddress['country'],
                'shippingState' => $shippingAddress['state'],
                'shippingPostalCode' => $shippingAddress['postcode'],
                'shippingPhone' => $shippingAddress['telephone'],
                'shippingEmail' => $orderDataEmail,
                'shippingBirthDate' => $orderDataBirthDate
            );

            $documentNumber = $this->getPost('cc_cpf');
            $customerType = 'Individual';
            $documentType = 'CPF';

            $data['customerIdExt'] = $documentNumber;

            $documentNumber = $this->clean_number($documentNumber);
            if (strlen($documentNumber) == '14') {
                $customerType = 'Legal entity';
                $documentType = 'CNPJ';
            }

            $data['billingType'] = $customerType;//'Legal entity'
            $data['billingDocumentType'] = $documentType;
            $data['billingDocumentValue'] = $documentNumber;

            $data['shippingType'] = $customerType;//'Legal entity'
            $data['shippingDocumentType'] = $documentType;
            $data['shippingDocumentValue'] = $documentNumber;

            if (isset($address['billing']['telephone'])) {
                $billingTelephone = $address['billing']['telephone'];

                $data['billingPhoneType'] = 'Mobile';
                $data['billingCountryCode'] = $this->getCountryCode();
                $data['billingPhoneAreaCode'] = $this->getAreaNumber($billingTelephone);
                $data['billingPhoneNumber'] = $this->getPhoneNumber($billingTelephone);
            }

            if (isset($address['shipping']['telephone'])) {
                $shippingTelephone = $address['shipping']['telephone'];

                $data['shippingPhoneType'] = 'Mobile';
                $data['shippingCountryCode'] = $this->getCountryCode();
                $data['shippingPhoneAreaCode'] = $this->getAreaNumber($shippingTelephone);
                $data['shippingPhoneNumber'] = $this->getPhoneNumber($shippingTelephone);
            }

            $data = array_merge($data, $order_data, $address_data);

            if ($processingType == 'auth') {

                $fraud_processor = $this->config->get('maxipago_cc_fraud_processor');
                if ($fraud_processor) {
                    $data['fraudProcessorID'] = $fraud_processor;

                    $autoCapture = $this->config->get('maxipago_cc_auto_capture');
                    $autoVoid = $this->config->get('maxipago_cc_auto_void');

                    $data['captureOnLowRisk'] = $autoCapture;
                    $data['voidOnHighRisk'] = $autoVoid;

                    if ($fraud_processor == '98') {
                        $sessionId = session_id();
                        $data['fraudToken'] = $sessionId;
                    } else if ($fraud_processor == '99') {
                        $merchantId = $this->config->get('maxipago_store_id');
                        $merchantSecret = $this->config->get('maxipago_secret_key');
                        $hash = hash_hmac('md5', $merchantId . '*' . $order_id, $merchantSecret);
                        $data['fraudToken'] = $hash;
                    }
                    $data['websiteId'] = 'DEFAULT';
                }

                $this->getMaxipago()->creditCardAuth($data);
            } else {
                $this->getMaxipago()->creditCardSale($data);
            }

            $response = $this->getMaxipago()->response;

            $this->log($this->hideXMLSensitiveInformation($this->getMaxipago()->xmlRequest));
            $this->log($this->getMaxipago()->xmlResponse);

            $this->_saveTransaction('card', $data, $response);

        }

        return $response;
    }

    public function recurringMethod($order_data, $recurring_data)
    {
        $methodEnabled = $this->config->get('maxipago_cc_enabled');
        
        if (!$methodEnabled) {
            $this->load->language('payment/maxipago');
            throw new Exception($this->language->get('exception_method_not_allowed'));
        }

        $reference_number = $order_data['order_id'];
        $ip_address = $order_data['ip'];
        $currency_code = $order_data['currency_code'];

        $charge_total = (float) $recurring_data['recurring_price'];
        $formated_charge_total = number_format($charge_total, 2, '.', '');

        $shippingTotal = $this->getOrderShippingValue($order_data['order_id']);
        $shippingTotal = number_format($shippingTotal, 2, '.', '');

        $document = $this->getPost('cc_cpf');

        $request_data = array(
            'referenceNum' => $reference_number,
            'ipAddress' => $ip_address,
            'customerIdExt' => $document,
            'currencyCode' => $currency_code,
            'chargeTotal' => $formated_charge_total,
            'shippingTotal' => $shippingTotal
        );

        $using_saved_cc = $this->getPost('cc_saved_card');

        if ($using_saved_cc) {
            $request_data['customerId'] = $order_data['customer_id'];

            $saved_cvv = $this->getPost('cc_cvv2_saved');
            $request_data['cvvNumber'] = $saved_cvv;

            $sql = 'SELECT *
                        FROM ' . DB_PREFIX . 'maxipago_cc_token
                        WHERE `id_customer` = \'' . $order_data['customer_id'] . '\'
                        AND `description` = \'' . $using_saved_cc . '\'
                        LIMIT 1; ';
            $maxipago_token = $this->db->query($sql)->row;
            $request_data['token'] = $maxipago_token['token'];

            $processor_id =  $this->config->get('maxipago_' . $maxipago_token['brand'] . '_processor');
            $request_data['processorID'] = $processor_id;
        } else {
            $request_data['customerId'] = $order_data['customer_id'];

            $cc_brand = $this->getPost('cc_brand');
            $processor_id =  $this->config->get('maxipago_' . strtolower($cc_brand) . '_processor');
            $request_data['processorID'] = $processor_id;

            $expiration_month = $this->getPost('cc_expire_date_month');
            $request_data['expMonth'] = $expiration_month;

            $xpiration_year = $this->getPost('cc_expire_date_year');
            $request_data['expYear'] = $xpiration_year;

            $cc_number = $this->getPost('cc_number');
            $request_data['number'] = $cc_number;

            $cc_cvv = $this->getPost('cc_cvv2');
            $request_data['cvvNumber'] = $cc_cvv;

            $save_card = $this->getPost('cc_save_card');
            if ($save_card) {
                $this->saveCard($order_data);
            }
        }

        $has_trial = $recurring_data['recurring_trial'] == "1";
        $trial_is_paid = $has_trial ? ((float) $recurring_data['recurring_trial_price']) > 0 : false;

        if($has_trial && $trial_is_paid)
            throw new Exception($this->language->get('exception_recurrency_not_supported'));

        if($has_trial)
        {
            $frequencyFromMaxiPagoToOpenCart = array(
                'daily' => 'day',
                'weekly' => 'week',
                'monthly' => 'month'
            );

            $frequency = $this->getFrequencyFromCycle($recurring_data['recurring_cycle'], $recurring_data['recurring_frequency']);
            $request_data['frequency'] = $frequency;

            $period = $this->getPeriodFromFrequency($recurring_data['recurring_frequency']);
            $request_data['period'] = $period;

            $trial_frequency = $this->getFrequencyFromCycle($recurring_data['recurring_trial_cycle'], $recurring_data['recurring_trial_frequency']);
            $trial_period = $this->getPeriodFromFrequency($recurring_data['recurring_trial_frequency']);

            $start_date = new DateTime('today');
            $start_date->modify('+' . $trial_frequency . ' ' . $frequencyFromMaxiPagoToOpenCart[$trial_period]);
            $start_date = $start_date->format('Y-m-d');
            $request_data['startDate'] = $start_date;

            $installments = $this->getRecurringInstallments($recurring_data['recurring_duration'], $period, $frequency);
            $request_data['installments'] = $installments;

            $failure_threshold = $installments > 99 ? 99 : $installments;
            $request_data['failureThreshold'] = $failure_threshold;
        } else
        {
            $start_date = new DateTime('today');
            $start_date = $start_date->format('Y-m-d');
            $request_data['startDate'] = $start_date;

            $frequency = $this->getFrequencyFromCycle($recurring_data['recurring_cycle'], $recurring_data['recurring_frequency']);
            $request_data['frequency'] = $frequency;

            $period = $this->getPeriodFromFrequency($recurring_data['recurring_frequency']);
            $request_data['period'] = $period;

            $installments = $this->getRecurringInstallments($recurring_data['recurring_duration'], $period, $frequency);
            $request_data['installments'] = $installments;

            $failure_threshold = $installments > 99 ? 99 : $installments;
            $request_data['failureThreshold'] = $failure_threshold;
        }
    
        $address = $this->_getAddress($order_data);
        $billingAddress = $address['billing'];
        $shippingAddress = $address['shipping'];

        $district = isset($order_data['district']) ? $order_data['district'] : 'N/A';
        $birthdate = isset($order_data['birthdate']) ? $order_data['birthdate'] : '1990-01-01';
        $gender = isset($order_data['gender']) ? $order_data['gender'] : 'M';

        $request_data['billingId'] = $order_data['customer_id'];
        $request_data['billingName'] = $billingAddress['firstname'] . ' ' . $billingAddress['lastname'];
        $request_data['billingAddress'] = $billingAddress['address1'];
        $request_data['billingAddress1'] = $billingAddress['address1'];
        $request_data['billingAddress2'] = $billingAddress['address2'];
        $request_data['billingDistrict'] = $district;
        $request_data['billingCity'] = $billingAddress['city'];
        $request_data['billingState'] = $billingAddress['state'];
        $request_data['billingZip'] = $billingAddress['postcode'];
        $request_data['billingPostalCode'] = $billingAddress['postcode'];
        $request_data['billingCountry'] = $order_data['payment_iso_code_2'];
        $request_data['billingEmail'] = $order_data['email'];
        $request_data['billingBirthDate'] = $birthdate;
        $request_data['billingGender'] = $gender;
        $request_data['billingPhone'] = $address['telephone'];

        $request_data['shippingId'] = $order_data['customer_id'];
        $request_data['shippingName'] = $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'];
        $request_data['shippingAddress'] = $shippingAddress['address1'];
        $request_data['shippingAddress1'] = $shippingAddress['address1'];
        $request_data['shippingAddress2'] = $shippingAddress['address2'];
        $request_data['shippingDistrict'] = $district;
        $request_data['shippingCity'] = $shippingAddress['city'];
        $request_data['shippingState'] = $shippingAddress['state'];
        $request_data['shippingZip'] = $shippingAddress['postcode'];
        $request_data['shippingPostalCode'] = $shippingAddress['postcode'];
        $request_data['shippingCountry'] = $order_data['payment_iso_code_2'];
        $request_data['shippingEmail'] = $order_data['email'];
        $request_data['shippingBirthDate'] = $birthdate;
        $request_data['shippingGender'] = $gender;
        $request_data['shippingPhone'] = $shippingAddress['telephone'];

        $this->getMaxipago()->createRecurring($request_data);
        $response = $this->getMaxipago()->response;

        $xmlRequest = $this->getMaxipago()->xmlRequest;
        $xmlRequest = preg_replace('/<number>(.*)<\/number>/m', '<number>*****</number>', $xmlRequest);
        $xmlRequest = preg_replace('/<cvvNumber>(.*)<\/cvvNumber>/m', '<cvvNumber>***</cvvNumber>', $xmlRequest);
        $xmlRequest = preg_replace('/<token>(.*)<\/token>/m', '<token>***</token>', $xmlRequest);
        $this->log($xmlRequest);
        $this->log($this->getMaxipago()->xmlResponse);

        $this->_saveRecurringTransaction($order_data['order_id'], $recurring_data['recurring_id'], $request_data, $response);
        return $response;
    }

    private function _saveRecurringTransaction($order_id, $order_recurring_id, $request, $response)
    {
        $maxipago_order_id = '';
        if(isset($response['orderID']))
            $maxipago_order_id = $this->db->escape($response['orderID']);

        $maxipago_status = '';
        if(isset($response['responseMessage']))
            $maxipago_status = $this->db->escape($response['responseMessage']);

        if(isset($request['number']))
            $request['number'] = substr($request['number'], 0, 6) . 'XXXXXX' . substr($request['number'], -4, 4);

        if(isset($request['token']))
            $request['token'] = 'XXXXXXXXXXXX';

        if(isset($request['cvv']))
            $request['cvv'] = 'XXX';

        if(isset($request['cvvNumber']))
            $request['cvvNumber'] = 'XXX';

        if(isset($request['creditCardData']))
            unset($request['creditCardData']);

        $request = $this->db->escape(json_encode($request));
        $response = $this->db->escape(json_encode($response));

        $sql = 'INSERT INTO `' . DB_PREFIX . 'maxipago_recurring_transactions` 
                    (`order_id`, `order_recurring_id`, `maxipago_order_id`, `maxipago_status`, `request`, `response`)
                VALUES
                    ("' . $order_id . '", "' . $order_recurring_id . '",  "' . $maxipago_order_id . '", "' . $maxipago_status . '", "' . $request . '", "' . $response . '" )
                ';

        $this->db->query($sql);
    }

    private function getFrequencyFromCycle($cycle, $frequency)
    {
        $multiplier = 1;

        if($frequency == 'semi_month')
            $multiplier = 15;

        if($frequency == 'year')
            $multiplier = 12;

        return $cycle * $multiplier;
    }

    private function getPeriodFromFrequency($frequency)
    {
        $frequencyFromOpenCartToMaxiPago = array(
            'day' => 'daily',
            'week' => 'weekly',
            'semi_month' => 'daily',
            'month' => 'monthly',
            'year' => 'monthly'
        );

        if(isset($frequencyFromOpenCartToMaxiPago[$frequency]))
            return $frequencyFromOpenCartToMaxiPago[$frequency];

        return 'monthly';
    }

    private function getRecurringInstallments($duration, $period, $frequency)
    {
        if($duration > 0)
            return $duration;

        // 1825 days is the same as 5 years
        if($period == 'daily')
            return (int) (1825 / $frequency);

        // 260 weeks is the same as 5 years
        if($period == 'weekly')
            return (int) (260 / $frequency);

        // 60 months is the same as 5 years
        if($period == 'monthly')
            return (int) (60 / $frequency);

        return 0; // Shall thrown error for invalid
    }

    public function voidOrder($order_id)
    {
        $this->voidAllOrderPayments($order_id);
        $this->voidAllOrderRecurringPayments($order_id);
    }

    private function voidAllOrderRecurringPayments($order_id)
    {
        try
        {
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_recurring_transactions
                    WHERE `order_id` = "' . $order_id . '"';

            $transactions = $this->db->query($sql)->rows;

            if(!empty($transactions))
            {
                foreach($transactions as $transaction)
                {
                    $response = json_decode($transaction['response']);

                    $data = array(
                        'transactionID' => $response->transactionID
                    );

                    $this->getMaxipago()->creditCardVoid($data);
                }

                $this->_updateRecurringTransactionsState($order_id);
            }

        } catch (Exception $e)
        {
            $this->log('Error voiding order ' . $order_id . ': ' . $e->getMessage());
        }
    }

    private function voidAllOrderPayments($order_id)
    {
        try
        {
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_transactions
                    WHERE `id_order` = "' . $order_id . '"
                    AND `method` = "credit-card"';

            $transaction = $this->db->query($sql)->row;

            if(!empty($transaction))
            {
                $request = json_decode($transaction['request']);
                $response = json_decode($transaction['return']);

                $data = array(
                    'transactionID' => $response->transactionID
                );

                $this->getMaxipago()->creditCardVoid($data);
                $this->_updateTransactionState($order_id);
            }

        } catch (Exception $e)
        {
            $this->log('Error voiding order ' . $order_id . ': ' . $e->getMessage());
        }
    }

    protected function _updateRecurringTransactionsState($id_order)
    {
        $this->load->language('payment/maxipago');
        $this->load->model('payment/maxipago');

        $sql = 'SELECT * FROM ' . DB_PREFIX . 'maxipago_recurring_transactions
            WHERE `order_id` = "' . $id_order . '"';

        $transactions = $this->db->query($sql)->rows;

        if(!empty($transactions))
        {
            foreach($transactions as $transaction)
            {
                $return = json_decode($transaction['response']);

                $search = array(
                    'orderID' => $return->orderID
                );

                $this->getMaxipago()->pullReport($search);
                $response = $this->getMaxipago()->getReportResult();

                if (! empty($response))
                {
                    $responseCode = isset($response[0]['responseCode']) ? $response[0]['responseCode'] : $return->responseCode;
                    if (! property_exists($return, 'originalResponseCode')) {
                        $return->originalResponseCode = $return->responseCode;
                    }
                    $return->responseCode = $responseCode;

                    if (! property_exists($return, 'originalResponseMessage')) {
                        $return->originalResponseMessage = $return->responseMessage;
                    }
                    $state = isset($response[0]['transactionState']) ? $response[0]['transactionState'] : null;
                    $responseMessage = (array_key_exists($state, $this->_transactionStates)) ? $this->_transactionStates[$state] : $return->responseMessage;
                    $return->responseMessage = $responseMessage;
                    $return->transactionState = $state;
                    $transaction['response_message'] = $responseMessage;

                    $sql = 'UPDATE ' . DB_PREFIX . 'maxipago_recurring_transactions
                                   SET `maxipago_status` = \'' . strtoupper($responseMessage) . '\',
                                       `response` = \'' . json_encode($response[0]) . '\'
                                 WHERE `order_id` = "' . $id_order . '"
                                 and `order_recurring_id` = "' . $transaction['order_recurring_id'] . '"
                                ';

                    $this->db->query($sql);
                }
            }
        }
    }

    public function debitCardMethod($order_info)
    {
        $method_enabled = $this->config->get('maxipago_dc_enabled');

        if(!$method_enabled)
            return array(
                'error' => true,
                'message' => 'Debit card is not enabled'
            );

            $request_data = array();

            $reference_number = $order_info['order_id'];
            $request_data['referenceNum'] = $reference_number;
    
            $ip_address = $order_info['ip'];
            $request_data['ipAddress'] = $ip_address;
            $request_data['customerIdExt'] = $this->getPost('dc_document');
    
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $request_data['userAgent'] = $user_agent;
    
            $card = array(
                'brand' => $this->getPost('dc_brand'),
                'number' => $this->getPost('dc_number'),
                'expiry' => array(
                    'month' => $this->getPost('dc_expiry_month'),
                    'year' => $this->getPost('dc_expiry_year')
                ),
                'cvv' => $this->getPost('dc_cvv'),
                'document' => $this->getPost('dc_document')
            );
            $request_data['number'] = $card['number'];
            $request_data['expMonth'] = $card['expiry']['month'];
            $request_data['expYear'] = $card['expiry']['year'];
            $request_data['cvvNumber'] = $card['cvv'];
    
            $card_processor = $this->config->get('maxipago_dc_' . strtolower($card['brand']) . '_processor');
            $request_data['processorID'] = $card_processor;
    
            $address = $this->_getAddress($order_info);
            $billingAddress = $address['billing'];
            $shippingAddress = $address['shipping'];
            $district = isset($order_info['district']) ? $order_info['district'] : 'N/A';
            $birthdate = isset($order_info['birthdate']) ? $order_info['birthdate'] : '1990-01-01';
            $gender = isset($order_info['gender']) ? $order_info['gender'] : 'M';
    
            $request_data['billingId'] = $order_info['customer_id'];
            $request_data['billingName'] = $billingAddress['firstname'] . ' ' . $billingAddress['lastname'];
            $request_data['billingAddress'] = $billingAddress['address1'];
            $request_data['billingAddress1'] = $billingAddress['address1'];
            $request_data['billingAddress2'] = $billingAddress['address2'];
            $request_data['billingDistrict'] = $district;
            $request_data['billingCity'] = $billingAddress['city'];
            $request_data['billingState'] = $billingAddress['state'];
            $request_data['billingZip'] = $billingAddress['postcode'];
            $request_data['billingPostalCode'] = $billingAddress['postcode'];
            $request_data['billingCountry'] = $order_info['payment_iso_code_2'];
            $request_data['billingPhone'] = $billingAddress['telephone'];
            $request_data['billingEmail'] = $order_info['email'];
            $request_data['billingBirthDate'] = $birthdate;
            $request_data['billingGender'] = $gender;
    
            $request_data['shippingId'] = $order_info['customer_id'];
            $request_data['shippingName'] = $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'];
            $request_data['shippingAddress'] = $shippingAddress['address1'];
            $request_data['shippingAddress1'] = $shippingAddress['address1'];
            $request_data['shippingAddress2'] = $shippingAddress['address2'];
            $request_data['shippingDistrict'] = $district;
            $request_data['shippingCity'] = $shippingAddress['city'];
            $request_data['shippingState'] = $shippingAddress['state'];
            $request_data['shippingZip'] = $shippingAddress['postcode'];
            $request_data['shippingPostalCode'] = $shippingAddress['postcode'];
            $request_data['shippingCountry'] = $order_info['payment_iso_code_2'];
            $request_data['shippingPhone'] = $shippingAddress['telephone'];
            $request_data['shippingEmail'] = $order_info['email'];
            $request_data['shippingBirthDate'] = $birthdate;
            $request_data['shippingGender'] = $gender;
    
            $charge_total = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
            $request_data['chargeTotal'] = $charge_total;
            $request_data['currencyCode'] = $order_info['currency_code'];

            $shippingTotal = $this->getOrderShippingValue($order_info['order_id']);
            $shippingTotal = number_format($shippingTotal, 2, '.', '');
            $request_data['shippingTotal'] = $shippingTotal;
    
            $mpi_processor = $this->config->get('maxipago_dc_mpi_processor');
            $request_data['mpiProcessorID'] = $mpi_processor;
    
            $failure_action = $this->config->get('maxipago_dc_failure_action');
            $request_data['onFailure'] = $failure_action;
    
            $soft_descriptor = $this->config->get('maxipago_dc_soft_descriptor');
            if($soft_descriptor)
                $request_data['softDescriptor'] = $soft_descriptor;
    
            $this->getMaxipago()->saleDebitCard3DS($request_data);
            $response = $this->getMaxipago()->response;
    
            $this->log($this->hideXMLSensitiveInformation($this->getMaxipago()->xmlRequest));
            $this->log($this->getMaxipago()->xmlResponse);
    
            $authentication_url = isset($response['authenticationURL']) ? $response['authenticationURL'] : null;
            $this->_saveTransaction('debit', $request_data, $response, $authentication_url);
            return $response;
    }

    /**
     * Send the payment method EFT to maxiPago!
     *
     * @param $order_info
     * @return boolean
     */
    public function eftMethod($order_info)
    {
        $response = null;
        $methodEnabled = $this->config->get('maxipago_eft_enabled');

        if ($methodEnabled) {

            //Order Data
            $totalOrder = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);

            $shippingTotal = $this->getOrderShippingValue($order_info['order_id']);
            $shippingTotal = number_format($shippingTotal, 2, '.', '');

            $order_id = $this->session->data['order_id'];
            $customerId = $order_info['customer_id'];

            $environment = $this->config->get('maxipago_environment');

            $tefBank = ($environment == 'test') ? 17 : $this->getPost('eft_bank');
            $cpf = $this->getPost('eft_cpf');
            $ipAddress = isset($_SERVER['REMOTE_ADDR']) ? $this->validateIP($_SERVER['REMOTE_ADDR']) : self::DEFAULT_IP;

            $address = $this->_getAddress($order_info);
            $billingAddress = $address['billing'];
            $shippingAddress = $address['shipping'];

            $data = array(
                'referenceNum' => $order_id, //Order ID
                'processorID' => $tefBank, //Bank Number
                'ipAddress' => $ipAddress,
                'chargeTotal' => $totalOrder,
                'shippingTotal' => $shippingTotal,
                'customerIdExt' => $cpf,
                'name' => $billingAddress['firstname'] . ' ' . $billingAddress['lastname'],
                'address' => $billingAddress['address1'], //Address 1
                'address2' => $billingAddress['address2'], //Address 2
                'city' => $billingAddress['city'],
                'state' => $billingAddress['state'],
                'postalcode' => $billingAddress['postcode'],
                'country' => $billingAddress['country'],
                'parametersURL' => 'oid=' . $order_id,
                'phone' => $billingAddress['telephone'],

                'billingId' => ($customerId) ? $customerId : $order_info['email'],
                'billingName' => $billingAddress['firstname'] . ' ' . $billingAddress['lastname'],
                'billingAddress' => $billingAddress['address1'],
                'billingAddress2' => $billingAddress['address2'],
                'billingCity' => $billingAddress['city'],
                'billingState' => $billingAddress['state'],
                'billingPostalCode' => $billingAddress['postcode'],
                'billingPhone' => $billingAddress['telephone'],
                'billingEmail' => $order_info['email'],

                'shippingId' => ($customerId) ? $customerId : $order_info['email'],
                'shippingName' => $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'],
                'shippingAddress' => $shippingAddress['address1'],
                'shippingAddress2' => $shippingAddress['address2'],
                'shippingCity' => $shippingAddress['city'],
                'shippingState' => $shippingAddress['state'],
                'shippingPostalCode' => $shippingAddress['postcode'],
                'shippingPhone' => $shippingAddress['telephone'],
                'shippingEmail' => $order_info['email'],
            );

            $this->getMaxipago()->onlineDebitSale($data);
            $response = $this->getMaxipago()->response;

            $this->log($this->getMaxipago()->xmlRequest);
            $this->log($this->getMaxipago()->xmlResponse);

            $onlineDebitUrl = isset($response['onlineDebitUrl']) ? $response['onlineDebitUrl'] : null;
            $this->_saveTransaction('eft', $data, $response, $onlineDebitUrl);

        }

        return $response;

    }

    public function redepayMethod($order_info)
    {
        $method_enabled = $this->config->get('maxipago_redepay_enabled');

        if(!$method_enabled)
            return array(
                'error' => true,
                'message' => 'Redepay is not enabled!'
            );

        $request_data = array(
            'processorID' => 18,
            'parametersURL' => 'type=redepay'
        );

        $ip_address = $order_info['ip'];
        $request_data['ipAddress'] = $ip_address;

        $reference_number = $order_info['order_id'];
        $request_data['referenceNum'] = $reference_number;

        $charge_total = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $request_data['chargeTotal'] = $charge_total;

        $shipping_total = $this->getOrderShippingValue($order_info['order_id']);
        $shipping_total = $this->currency->format($shipping_total, $order_info['currency_code'], $order_info['currency_value'], false);
        $request_data['shippingTotal'] = $shipping_total;

        $address = $this->_getAddress($order_info);
        $billingAddress = $address['billing'];
        $shippingAddress = $address['shipping'];
        $district = isset($order_info['district']) ? $order_info['district'] : 'N/A';
        $birthdate = isset($order_info['birthdate']) ? $order_info['birthdate'] : '1990-01-01';
        $gender = isset($order_info['gender']) ? $order_info['gender'] : 'M';
        $billingPhone = $billingAddress['telephone'];
        $shippingPhone = $shippingAddress['telephone'];

        $request_data['billingId'] = $order_info['customer_id'];
        $request_data['billingName'] = $billingAddress['firstname'] . ' ' . $billingAddress['lastname'];
        $request_data['billingAddress'] = $billingAddress['address1'];
        $request_data['billingAddress1'] = $billingAddress['address1'];
        $request_data['billingAddress2'] = $billingAddress['address2'];
        $request_data['billingDistrict'] = $district;
        $request_data['billingCity'] = $billingAddress['city'];
        $request_data['billingState'] = $billingAddress['state'];
        $request_data['billingZip'] = $billingAddress['postcode'];
        $request_data['billingPostalCode'] = $billingAddress['postcode'];
        $request_data['billingCountry'] = $billingAddress['country'];
        $request_data['billingEmail'] = $order_info['email'];
        $request_data['billingBirthDate'] = $birthdate;
        $request_data['billingGender'] = $gender;
        $request_data['billingPhone'] = $billingPhone;

        $request_data['shippingId'] = $order_info['customer_id'];
        $request_data['shippingName'] = $shippingAddress['firstname'] . ' ' . $shippingAddress['lastname'];
        $request_data['shippingAddress'] = $shippingAddress['address1'];
        $request_data['shippingAddress1'] = $shippingAddress['address1'];
        $request_data['shippingAddress2'] = $shippingAddress['address2'];
        $request_data['shippingDistrict'] = $district;
        $request_data['shippingCity'] = $shippingAddress['city'];
        $request_data['shippingState'] = $shippingAddress['state'];
        $request_data['shippingZip'] = $shippingAddress['postcode'];
        $request_data['shippingPostalCode'] = $shippingAddress['postcode'];
        $request_data['shippingCountry'] = $shippingAddress['country'];
        $request_data['shippingEmail'] = $order_info['email'];
        $request_data['shippingBirthDate'] = $birthdate;
        $request_data['shippingGender'] = $gender;
        $request_data['shippingPhone'] = $shippingPhone;

        $billingPhoneCountryCode = $this->getCountryCode($billingAddress['country']);
        $shippingPhoneCountryCode = $this->getCountryCode($shippingAddress['country']);

        if(substr($billingPhone, 0, 2) == $billingPhoneCountryCode)
            $billingPhone = substr($billingPhone, 2, (strlen($billingPhone) - 2));

        if(substr($shippingPhone, 0, 2) == $shippingPhoneCountryCode)
            $shippingPhone = substr($shippingPhone, 2, (strlen($shippingPhone) - 2));

        $request_data['billingPhoneType'] = 'Mobile';
        $request_data['billingCountryCode'] = $billingPhoneCountryCode;
        $request_data['billingPhoneAreaCode'] = $this->getAreaNumber($billingPhone);
        $request_data['billingPhoneNumber'] = $this->getPhoneNumber($billingPhone);

        $request_data['shippingPhoneType'] = 'Mobile';
        $request_data['shippingCountryCode'] = $shippingPhoneCountryCode;
        $request_data['shippingPhoneAreaCode'] = $this->getAreaNumber($shippingPhone);
        $request_data['shippingPhoneNumber'] = $this->getPhoneNumber($shippingPhone);

        $customer_type = 'Individual';
        $customer_document_type = 'CPF';
        $customer_document_number = $this->getPost('redepay_document');
        $customer_document_number = preg_replace('/\D/', '', $customer_document_number);

        if(strlen($customer_document_number) == 14)
        {
            $customer_type = 'Legal entity';
            $customer_document_type = 'CNPJ';
        }

        $request_data['customerIdExt'] = $customer_document_number;

        $request_data['billingType'] = $customer_type;
        $request_data['billingDocumentType'] = $customer_document_type;
        $request_data['billingDocumentValue'] = $customer_document_number;

        $request_data['shippingType'] = $customer_type;
        $request_data['shippingDocumentType'] = $customer_document_type;
        $request_data['shippingDocumentValue'] = $customer_document_number;

        $this->getMaxipago()->redepay($request_data);
        $response = $this->getMaxipago()->response;

        $this->log($this->getMaxipago()->xmlRequest);
        $this->log($this->getMaxipago()->xmlResponse);

        $authentication_url = isset($response['authenticationURL']) ? $response['authenticationURL'] : null;
        $this->_saveTransaction('redepay', $request_data, $response, $authentication_url);
        return $response;
    }

    private function getOrderShippingValue($order_id) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "order_total`
        WHERE `order_id` = " . $order_id . " AND `code` = 'shipping';";
        $query = $this->db->query($sql);
        if ($query->num_rows) {
            return $query->row['value'];
        }
    }

    /**
     * Save the credit card at the database
     * @param $order_info
     * @return null
     */
    public function saveCard($order_info)
    {
        try {
            $this->load->language('payment/maxipago');

            $address = $this->_getAddress($order_info);

            $customerId = $order_info['customer_id'];
            $customerDocument = $this->getPost('cc_cpf');
            $firstname = $order_info['firstname'];
            $lastname = $order_info['lastname'];
            $mpCustomerId = null;

            $ccBrand = $this->getPost('cc_brand');
            $ccNumber = $this->getPost('cc_number');
            $ccExpMonth = $this->getPost('cc_expire_date_month');
            $ccExpYear = $this->getPost('cc_expire_date_year');

            $sql = 'SELECT *
                FROM ' . DB_PREFIX . 'maxipago_cc_token
                WHERE `id_customer` = \'' . $customerId . '\'
                LIMIT 1';
            $mpCustomer = $this->db->query($sql)->row;

            if (!$mpCustomer) {
                $customerData = array(
                    'customerIdExt' => $customerDocument,
                    'firstName' => $firstname,
                    'lastName' => $lastname
                );
                $this->getMaxipago()->addProfile($customerData);
                $response = $this->getMaxipago()->response;

                $this->_saveTransaction('add_profile', $customerData, $response, null, false);
                if (isset($response['errorCode']) && $response['errorCode'] == 1) {

                    //Search the table to see if the profile already exists
                    $sql = 'SELECT *
                            FROM ' . DB_PREFIX . 'maxipago_transactions
                            WHERE `method` = \'add_profile\';
                        ';

                    $query = $this->db->query($sql);

                    if ($query->num_rows) {
                        foreach ($query->rows as $row) {
                            $requestRow = json_decode($row['request']);
                            if (property_exists($requestRow, 'customerIdExt') && $requestRow->customerIdExt == $customerId) {
                                $responseRow = json_decode($row['return']);
                                if (property_exists($responseRow, 'result') && property_exists($responseRow->result, 'customerId')) {
                                    $mpCustomerId = $responseRow->result->customerId;
                                }
                            }
                        }
                    }
                } else {
                    $mpCustomerId = $this->getMaxipago()->getCustomerId();
                }

            } else {
                $mpCustomerId = $mpCustomer['id_customer_maxipago'];
            }

            if ($mpCustomerId) {
                $date = new DateTime($ccExpYear . '-' . $ccExpMonth . '-01');
                $date->modify('+1 month');
                $endDate = $date->format('m/d/Y');

                $ccData = array(
                    'customerId' => $mpCustomerId,
                    'creditCardNumber' => $ccNumber,
                    'expirationMonth' => $ccExpMonth,
                    'expirationYear' => $ccExpYear,
                    'billingId' => ($customerId) ? $customerId : $order_info['email'],
                    'billingName' => $address['billing']['firstname'] . ' ' . $address['billing']['lastname'],
                    'billingAddress' => $address['billing']['address1'],
                    'billingAddress2' => $address['billing']['address2'],
                    'billingCity' => $address['billing']['city'],
                    'billingState' => $address['billing']['state'],
                    'billingPostalCode' => $address['billing']['postcode'],
                    'billingPhone' => $address['billing']['telephone'],
                    'billingEmail' => $order_info['email'],
                    'shippingId' => ($customerId) ? $customerId : $order_info['email'],
                    'shippingName' => $address['shipping']['firstname'] . ' ' . $address['shipping']['lastname'],
                    'shippingAddress' => $address['shipping']['address1'],
                    'shippingAddress2' => $address['shipping']['address2'],
                    'shippingCity' => $address['shipping']['city'],
                    'shippingState' => $address['shipping']['state'],
                    'shippingPostalCode' => $address['shipping']['postcode'],
                    'shippingPhone' => $address['shipping']['telephone'],
                    'shippingEmail' => $order_info['email'],
                    'onFileEndDate' => $endDate,
                    'onFilePermissions' => 'ongoing',
                );

                $this->getMaxipago()->addCreditCard($ccData);
                $token = $this->getMaxipago()->getToken();
                $this->_saveTransaction('save_card', $ccData, $this->getMaxipago()->response, null, false);

                if ($token) {
                    $ccEnc = substr($ccNumber, 0, 6) . 'XXXXXX' . substr($ccNumber, -4, 4);
                    $sql = 'INSERT INTO `' . DB_PREFIX . 'maxipago_cc_token` 
                                (`id_customer`, `id_customer_maxipago`, `brand`, `token`, `description`)
                            VALUES
                                ("' . $customerId . '", "' . $mpCustomerId . '", "' . $ccBrand . '", "' . $token . '", "' . $ccEnc . '" )
                            ';

                    $this->db->query($sql);
                }
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function confirmRecurringPayments()
    {
        $post_data = $this->request->post;

        $this->load->model('checkout/order');

        $statuses = array(
            'processing' => $this->config->get('maxipago_order_processing'),
            'authorized' => $this->config->get('maxipago_order_authorized'),
            'approved' => $this->config->get('maxipago_order_approved')
        );

        $statuses_aux = array(
            $statuses['processing'] => 'PENDING',
            $statuses['authorized'] => 'AUTHORIZED',
            $statuses['approved'] => 'CAPTURED'
        );

        $message = '';
        $status = $statuses['processing'];
        $order_id = $this->session->data['order_id'];

        if(count($post_data) <= 2)
            return array(
                'error' => true,
                'message' => 'Missing information for confirmation'
            );

        for($index = 0; $index < (count($post_data) - 2); $index++)
        {
            // The transactions have already been analyzed, and in this step, every transaction is a success!
            $transaction = $post_data[$index];

            if($transaction['responseMessage'] == 'AUTHORIZED')
                $status = $statuses['authorized'];

            if($transaction['responseMessage'] == 'CAPTURED')
                if($status != $statuses['authorized'])
                    $status = $statuses['approved'];

            $transaction_message = '';
            if($transaction['product_data_type'] == 'common')
            {
                $transaction_message = $this->language->get('common_products_transaction_message');
                $transaction_message = sprintf($transaction_message, count($transaction['product_data']), $transaction['responseMessage']);
            } else if($transaction['product_data_type'] == 'recurring')
            {
                $transaction_message = $this->language->get('recurring_product_transaction_message');
                $transaction_message = sprintf($transaction_message, $transaction['product_data']['name'], $transaction['product_data']['profile_name']);
            }
            $message .= '<p>' . $transaction_message . '</p>';

            $mp_order_id = $transaction['orderID'];
            $mp_transaction_id = $transaction['transactionID'];
            $mp_auth_code = $transaction['authCode'];

            $has_aditional_information = $mp_order_id || $mp_transaction_id || $mp_auth_code;

            if($has_aditional_information)
                $message .= '<ul>';

            if ($mp_order_id)
                $message .= '<li>orderID: ' . $mp_order_id . '</li>';

            if ($mp_transaction_id)
                $message .= '<li>transactionID: ' . $mp_transaction_id . '</li>';

            if ($mp_auth_code)
                $message .= '<li>authCode: ' . $mp_auth_code . '</li>';

            if($has_aditional_information)
                $message.= '</ul>';

            if(($index + 1) < (count($post_data) - 2))
                $message .= '<hr />';
        }

        if($status == $statuses['approved'] || $status == $statuses['authorized'])
            $message = $this->language->get('order_cc_text') . ' ' . $statuses_aux[$status] . $message;

        $this->_addOrderHistory($order_id, $status, $message, true);

        return array(
            'url' => $this->url->link('checkout/success', '', true)
        );
    }

    /**
     * Controller that confirms the payment
     */
    public function confirmPayment()
    {
        $this->load->model('checkout/order');

        $paymentType = $this->getPost('type');
        $responseCode = $this->getPost('responseCode');
        $responseMessage = $this->getPost('responseMessage');

        $order_id = $this->session->data['order_id'];
        $status = $this->config->get('config_order_status_id');

        $response = array(
            'error' => true,
            'message' => 'Payment type ' . $paymentType . ' not found'
        );

        switch ($responseCode) {
            //Aprovada
            case '0':

                $status = $this->config->get('maxipago_order_processing');
                if ($paymentType == 'eft') {

                    $url = $this->getPost('onlineDebitUrl');
                    $link = '<p><a href="' . $url . '" target="_blank">' . $this->language->get('eft_link_text') . '</a></p>';
                    $message = $this->language->get('order_eft_text') . $link;

                    $orderInfoUrl = $this->url->link('account/order/info') . '&order_id=' . $order_id;

                    $response['error'] = false;
                    $response['url'] = $orderInfoUrl;
                } else if ($paymentType == 'ticket') {

                    //Gera o link do boleto da maxiPago! e coloca nos comentários do pedido
                    $url = $this->getPost('boletoUrl');
                    $link = '<p><a href="' . $url . '" target="_blank">' . $this->language->get('ticket_link_text') . '</a></p>';
                    $message = $this->language->get('order_ticket_text') . $link;

                    $orderInfoUrl = $this->url->link('account/order/info') . '&order_id=' . $order_id;

                    $response['error'] = false;
                    $response['url'] = $orderInfoUrl;
                } else if ($paymentType == 'dc') {
                    $message = '<p>' . $this->language->get('order_dc_text') . ' ' . $responseMessage . '</p>';

                    if($responseMessage == 'ENROLLED')
                    {
                        $url = $this->getPost('authenticationURL');

                        $link = '<a href="' . $url . '" target="_blank">' . $this->language->get('debit_link_text') . '</a>';
                        $message .= '<p>' . $this->language->get('order_dc_pay') . $link . '</p>';

                        $response = array(
                            'error' => false,
                            'url' => $url
                        );
                    }

                } else if ($paymentType == 'redepay') {
                    $message = '<p>' . $this->language->get('order_redepay_text') . ' ' . $responseMessage . '</p>';

                    $url = $this->getPost('authenticationURL');
                    $link = '<p><a href="' . $url . '" target="_blank">' . $this->language->get('redepay_link_text') . '</a></p>';
                    $message = $this->language->get('order_redepay_pay') . $link;

                    $response = array(
                        'error' => false,
                        'url' => $url
                    );
                } else {

                    $message = '<p>' . $this->language->get('order_cc_text') . ' ' . $responseMessage . '</p>';

                    if ($responseMessage == 'CAPTURED') {
                        $status = $this->config->get('maxipago_order_approved');
                    } else if ($responseMessage == 'AUTHORIZED') {
                        $status = $this->config->get('maxipago_order_authorized');
                    }

                    if ($this->getPost('installments')) {
                        $installments = $this->getPost('installments');
                        $total = $this->getPost('total');
                        $totalFormatted =  $this->currency->format($total, $this->session->data['currency']);
                        $installmentsValue = $this->currency->format(($total / $installments), $this->session->data['currency']);
                        $message .= '<p>Total: ' . $totalFormatted . ' - ' . $installments . 'x de ' . $installmentsValue . '</p>';
                    }

                    $response['error'] = false;
                    $response['url'] = $this->url->link('checkout/success', '', true);
                }

                if ($this->getPost('orderID')) {
                    $message .= '<p>orderID: ' . $this->getPost('orderID') . '</p>';
                }

                if ($this->getPost('transactionID')) {
                    $message .= '<p>transactionID: ' . $this->getPost('transactionID') . '</p>';
                }

                if ($this->getPost('authCode')) {
                    $message .= '<p>authCode: ' . $this->getPost('authCode') . '</p>';
                }

                break;

            //Cancelado
            case '1':
            case '2':
                $status = $this->config->get('maxipago_order_cancelled');
                $message = $this->language->get('maxipago_order_cancelled');
                $response['message'] = $message;
                break;
            //Erro na transação
            default:
                $message = ($responseCode && isset($this->_responseCodes[$responseCode])) ? $this->_responseCodes[$responseCode] : $this->language->get('order_error');
                $response['message'] = $message;

                if ($this->getPost('errorMessage')) {
                    $message .= '<p>transactionID: ' . $this->getPost('errorMessage') . '</p>';
                    $response['message'] = $this->getPost('errorMessage');
                }
        }

        $this->_addOrderHistory($order_id, $status, $message);
        return $response;
    }

    protected function _addOrderHistory($order_id, $order_status_id, $comment, $notify = 1)
    {
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `order_status_id` = '" . (int)$order_status_id . "', `date_modified` = NOW() WHERE `order_id` = '" . (int)$order_id . "'");
        $this->db->query("INSERT INTO `" . DB_PREFIX . "order_history` SET `order_id` = '" . (int)$order_id . "', `order_status_id` = '" . (int)$order_status_id . "', `notify` = '" . $notify . "', `comment` = '" . $this->db->escape($comment) . "', `date_added` = NOW()");
    }

    /**
     * @param $order_info
     */
    public function capturePayment($order_info, $order_status_id)
    {
        try {
            $order_id = $order_info['order_id'];
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_transactions
                    WHERE `id_order` = "' . $order_id . '"
                    AND `method` = "card";';

            $transaction = $this->db->query($sql)->row;

            if (!empty($transaction) && $transaction['response_message'] != 'CAPTURED') {

                $request = json_decode($transaction['request']);
                $response = json_decode($transaction['return']);

                $data = array(
                    'orderID' => $response->orderID,
                    'referenceNum' => $response->referenceNum,
                    'chargeTotal' => $request->chargeTotal,
                );
                $this->getMaxipago()->creditCardCapture($data);
                $this->_saveTransaction('capture', $data, $this->getMaxipago()->response, null, false);
                $this->_updateTransactionState($order_id);

                return true;
            }

        } catch (Exception $e) {
            $this->log('Error capturing order ' . $order_id . ': ' . $e->getMessage());
        }
        return false;
    }

    /**
     * Refund an order
     * @param $order_info
     * @return bool
     */
    public function reversePayment($order_info)
    {
        try {
            $order_id = $order_info['order_id'];
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_transactions
                    WHERE `id_order` = "' . $order_id . '"
                    AND `method` = "card";';

            $transaction = $this->db->query($sql)->row;

            if (!empty($transaction)) {

                $request = json_decode($transaction['request']);
                $response = json_decode($transaction['return']);

                $data = array(
                    'orderID' => $response->orderID,
                    'referenceNum' => $response->referenceNum,
                    'chargeTotal' => $request->chargeTotal,
                );

                $this->getMaxipago()->creditCardRefund($data);
                $this->_saveTransaction('refund', $data, $this->getMaxipago()->response, null, false);
                $this->_updateTransactionState($order_id);

                return true;
            }

        } catch (Exception $e) {
            $this->log('Error refunding order ' . $order_id . ': ' . $e->getMessage());
        }

        return false;
    }

    /**
     * @param $order_info
     * @return array
     * Customer Address
     */
    protected function _getAddress($order_info)
    {
        $billingAddress = array();
        $shippingAddress = array();

        $billingFirstName = $order_info['payment_firstname'];
        $shippingFirstName = $order_info['shipping_firstname'];

        $billingLastName = $order_info['payment_lastname'];
        $shippingLastName = $order_info['shipping_lastname'];

        $billingISOCode = isset($order_info['payment_iso_code_2']) ? $order_info['payment_iso_code_2'] : 'BR';
        $shippingISOCode = isset($order_info['shipping_iso_code_2']) ? $order_info['shipping_iso_code_2'] : 'BR';

        $billingState = $order_info['payment_zone_code'];
        $shippingState = $order_info['shipping_zone_code'];

        $billingCity = $order_info['payment_city'];
        $shippingCity = $order_info['shipping_city'];

        $billingAddress1 = $order_info['payment_address_1'];
        $shippingAddress1 = $order_info['shipping_address_1'];

        $billingAddress2 = $order_info['payment_address_2'];
        $shippingAddress2 = $order_info['shipping_address_2'];

        $billingPostCode = $order_info['payment_postcode'];
        $shippingPostCode = $order_info['shipping_postcode'];

        $billingPostCode = preg_replace('/[^0-9]/', '', $billingPostCode);
        $shippingPostCode = preg_replace('/[^0-9]/', '', $shippingPostCode);

        $billingPostCode = substr($billingPostCode, 0, 5) . '-' . substr($billingPostCode, 5, 3);
        $shippingPostCode = substr($shippingPostCode, 0, 5) . '-' . substr($shippingPostCode, 5, 3);

        $telephone = preg_replace('/[^0-9]/', '', $order_info['telephone']);

        $billingAddress['firstname'] = $billingFirstName;
        $billingAddress['lastname'] = $billingLastName;
        $billingAddress['country'] = $billingISOCode;
        $billingAddress['state'] = $billingState;
        $billingAddress['city'] = $billingCity;
        $billingAddress['address1'] = $billingAddress1;
        $billingAddress['address2'] = $billingAddress2;
        $billingAddress['postcode'] = $billingPostCode;
        $billingAddress['telephone'] = $telephone;

        $shippingAddress['firstname'] = $shippingFirstName;
        $shippingAddress['lastname'] = $shippingLastName;
        $shippingAddress['country'] = $shippingISOCode;
        $shippingAddress['state'] = $shippingState;
        $shippingAddress['city'] = $shippingCity;
        $shippingAddress['address1'] = $shippingAddress1;
        $shippingAddress['address2'] = $shippingAddress2;
        $shippingAddress['postcode'] = $shippingPostCode;
        $shippingAddress['telephone'] = $telephone;

        return array(
            'billing' => $billingAddress,
            'shipping' => $shippingAddress
        );
    }

    /**
     * Update Transaction State to maxipago tables
     * @param $id_order
     * @param array $return
     * @param array $response
     * @return void
     */
    protected function _updateTransactionState($id_order, $return = array(), $response = array())
    {
        $this->load->language('payment/maxipago');
        $this->load->model('payment/maxipago');

        if (empty($return) ) {
            $sql = 'SELECT *
                        FROM ' . DB_PREFIX . 'maxipago_transactions
                        WHERE `id_order` = "' . $id_order . '" 
                        ';
            $transaction = $this->db->query($sql)->row;
            if (!empty($transaction)) {

                $return = json_decode($transaction['return']);

                $search = array(
                    'orderID' => $return->orderID
                );

                $this->getMaxipago()->pullReport($search);
                $response = $this->getMaxipago()->getReportResult();

                if (! empty($response) ) {
                    $responseCode = isset($response[0]['responseCode']) ? $response[0]['responseCode'] : $return->responseCode;
                    if (! property_exists($return, 'originalResponseCode')) {
                        $return->originalResponseCode = $return->responseCode;
                    }
                    $return->responseCode = $responseCode;

                    if (! property_exists($return, 'originalResponseMessage')) {
                        $return->originalResponseMessage = $return->responseMessage;
                    }
                    $state = isset($response[0]['transactionState']) ? $response[0]['transactionState'] : null;
                    $responseMessage = (array_key_exists($state, $this->_transactionStates)) ? $this->_transactionStates[$state] : $return->responseMessage;
                    $return->responseMessage = $responseMessage;
                    $return->transactionState = $state;
                    $transaction['response_message'] = $responseMessage;

                    $sql = 'UPDATE ' . DB_PREFIX . 'maxipago_transactions 
                               SET `response_message` = \'' . strtoupper($responseMessage) . '\',
                                   `return` = \'' . json_encode($return) . '\'
                             WHERE `id_order` = "' . $id_order . '";
                            ';

                    $this->db->query($sql);

                }

            }
        }


    }

    /**
     * Save at the DB the data of the transaction and the Boleto URL when the payment is made with boleto
     *
     * @param $method
     * @param $request
     * @param $return
     * @param null $transactionUrl
     * @param boolean $hasOrder
     */
    protected function _saveTransaction($method, $request, $return, $transactionUrl = null, $hasOrder = true)
    {
        $authentication_url = null;
        $onlineDebitUrl = null;
        $boletoUrl = null;

        if ($transactionUrl) {
            if ($method == 'eft') {
                $onlineDebitUrl = $transactionUrl;
            } else if ($method == 'ticket') {
                $boletoUrl = $transactionUrl;
            } else if ($method == 'debit' || $method == 'redepay') {
                $authentication_url = $transactionUrl;
            }
        }

        if (is_object($request) || is_array($request)) {

            if (isset($request['number'])) {
                $request['number'] = substr($request['number'], 0, 6) . 'XXXXXX' . substr($request['number'], -4, 4);
            }

            if (isset($request['cvvNumber'])) {
                $request['cvvNumber'] = 'XXXX';
            }
            if (isset($request['token'])) {
                $request['token'] = 'XXXXXXXXXX';
            }

            if ($this->getPost('cc_brand')) {
                $request['brand'] = $this->getPost('cc_brand');
            }

            $request = json_encode($request);
        }

        $responseMessage = null;
        if (is_object($return) || is_array($return)) {
            $responseMessage = isset($return['responseMessage']) ? $return['responseMessage'] : null;
            $return = json_encode($return);
        }

        $order_id = isset($this->session->data['order_id']) ? $this->session->data['order_id'] : 0;
        if (! $hasOrder) {
            $order_id = 0;
        }

        $request = $this->db->escape($request);
        $return = $this->db->escape($return);
        $responseMessage = $this->db->escape($responseMessage);

        $sql = 'INSERT INTO `' . DB_PREFIX . 'maxipago_transactions` 
                    (`id_order`, `boleto_url`, `online_debit_url`, `authentication_url`,`method`, `request`, `return`, `response_message`, `created_at`)
                VALUES
                    ("' . $order_id . '", "' . $boletoUrl . '",  "' . $onlineDebitUrl . '", "' . $authentication_url . '", "' . $method . '" ,"' . $request . '", "' . $return . '", "' . $responseMessage . '", NOW())
                ';

        $this->db->query($sql);
    }

    /**
     * Calculate the installments price for maxiPago!
     * @param $price
     * @param $installments
     * @param $interestRate
     * @return float
     */
    public function getInstallmentPrice($price, $installments, $interestRate)
    {
        $price = (float) $price;
        if ($interestRate) {
            $interestRate = (float)(str_replace(',', '.', $interestRate)) / 100;
            $type = $this->config->get('maxipago_cc_interest_type');
            $valorParcela = 0;
            switch ($type) {
                case 'price':
                    $value = round($price * (($interestRate * pow((1 + $interestRate), $installments)) / (pow((1 + $interestRate), $installments) - 1)), 2);
                    break;
                case 'compound':
                    //M = C * (1 + i)^n
                    $value = ($price * pow(1 + $interestRate, $installments)) / $installments;
                    break;
                case 'simple':
                    //M = C * ( 1 + ( i * n ) )
                    $value = ($price * (1 + ($installments * $interestRate))) / $installments;
            }
        } else {
            if ($installments)
                $value = $price / $installments;
        }
        return $value;
    }

    /**
     * Calculate the total of the order based on interest rate and installmentes
     * @param $price
     * @param $installments
     * @param $interestRate
     * @return float
     */
    public function getTotalByInstallments($price, $installments, $interestRate)
    {
        $installmentPrice = $this->getInstallmentPrice($price, $installments, $interestRate);
        return number_format($installmentPrice * $installments, 2 , '.', '');
    }

    /**
     * Get MAX installments for a price
     * @param null $price
     * @return array|bool
     */
    public function getInstallment($price = null)
    {
        $price = (float) $price;

        $maxInstallments = $this->config->get('maxipago_cc_max_installments');//
        $installmentsWithoutInterest = $this->config->get('maxipago_cc_installments_without_interest');
        $minimumPerInstallment = $this->config->get('maxipago_cc_min_per_installments');
        $minimumPerInstallment = (float)$minimumPerInstallment;

        if ($minimumPerInstallment > 0) {
            if ($minimumPerInstallment > $price / 2)
                return false;

            while ($maxInstallments > ($price / $minimumPerInstallment))
                $maxInstallments--;

            while ($installmentsWithoutInterest > ($price / $minimumPerInstallment))
                $installmentsWithoutInterest--;
        }

        $interestRate = str_replace(',', '.', $this->config->get('maxipago_cc_interest_rate'));
        $interestRate = ($maxInstallments <= $installmentsWithoutInterest) ? '' : $interestRate;

        $installmentValue = $this->getInstallmentPrice($price, $maxInstallments, $interestRate);
        $totalWithoutInterest = $installmentValue;

        if ($installmentsWithoutInterest)
            $totalWithoutInterest = $price / $installmentsWithoutInterest;

        $total = $installmentValue * $maxInstallments;

        return array(
            'total' => $total,
            'installments_without_interest' => $installmentsWithoutInterest,
            'total_without_interest' => $totalWithoutInterest,
            'max_installments' => $maxInstallments,
            'installment_value' => $installmentValue,
            'interest_rate' => $interestRate,
        );
    }

    /**
     * Get ALL POSSIBLE instalments for a price
     * @param null $price
     * @return array
     */
    public function getInstallments($order_info = array())
    {
        if (! is_array($order_info))
            return false;

        $price = (float) $order_info['total'];

        $maxInstallments = $this->config->get('maxipago_cc_max_installments');//
        $installmentsWithoutInterest = $this->config->get('maxipago_cc_installments_without_interest');
        $minimumPerInstallment = $this->config->get('maxipago_cc_min_per_installments');
        $interestRate = str_replace(',', '.', $this->config->get('maxipago_cc_interest_rate'));

        if ($minimumPerInstallment > 0) {
            while ($maxInstallments > ($price / $minimumPerInstallment)) $maxInstallments--;
        }
        $installments = array();
        if ($price > 0) {
            $maxInstallments = ($maxInstallments == 0) ? 1 : $maxInstallments;
            for ($i = 1; $i <= $maxInstallments; $i++) {
                $interestRateInstallment = ($i <= $installmentsWithoutInterest) ? '' : $interestRate;
                $value = ($i <= $installmentsWithoutInterest) ? ($price / $i) : $this->getInstallmentPrice($price, $i, $interestRate);
                $total = $value * $i;

                $installments[] = array(
                    'total' => $total,
                    'total_formated' => $this->currency->format($total, $order_info['currency_code']),
                    'installments' => $i,
                    'installment_value' => $value,
                    'installment_value_formated' => $this->currency->format($value, $order_info['currency_code']),
                    'interest_rate' => $interestRateInstallment
                );
            }
        }
        return $installments;
    }

    /**
     * Get post data validating if exists
     * @param $data
     * @return null
     */
    public function getPost($data)
    {
        return isset($this->request->post[$data]) ? $this->request->post[$data] : null;
    }

    /**
     * Get post data validating if exists
     * @param $data
     * @return null
     */
    public function getRequest($data)
    {
        $data = isset($this->request->get[$data]) ? $this->request->get[$data] : null;
        if (! $data) {
            $data = isset($this->request->post[$data]) ? $this->request->post[$data] : null;
        }
        return $data;
    }

    /**
     * @param $data
     * @param int $step
     */
    public function log($data, $step = 5)
    {
        if ($this->config->get('maxipago_logging')) {
            //$backtrace = debug_backtrace();
            $log = new Log('maxipago.log');

            $data = preg_replace('/<number>(.*)<\/number>/m', '<number>*****</number>', $data);
            $data = preg_replace('/<cvvNumber>(.*)<\/cvvNumber>/m', '<cvvNumber>***</cvvNumber>', $data);
            $data = preg_replace('/<token>(.*)<\/token>/m', '<token>***</token>', $data);

            $log->write('(LOG) - ' . $data);
        }
    }

    public function validateIP($ipAddress)
    {
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return $ipAddress;
        }

        return self::DEFAULT_IP;
    }


    public function clean_number($number)
    {
        return preg_replace('/\D/', '', $number);
    }


    public function getPhoneNumber($telefone)
    {
        if (strlen($telefone) >= 10) {
            $telefone = preg_replace('/^D/', '', $telefone);
            $telefone = substr($telefone, 2, strlen($telefone) - 2);
        }
        return $telefone;
    }

    public function getAreaNumber($telefone)
    {
        $telefone = preg_replace('/^D/', '', $telefone);
        $telefone = substr($telefone, 0, 2);
        return $telefone;
    }

    public function getOrderData()
    {
        //Cart Items
        $orderData = array();

        $i = 0;
        foreach($this->cart->getProducts() as $product) {
            if ($product['price'] > 0) {
                $i++;

                $orderData['itemIndex' . $i] = $i;
                $orderData['itemProductCode' . $i] = $product['product_id'];
                $orderData['itemDescription' . $i] = $product['name'];
                $orderData['itemQuantity' . $i] = $product['quantity'];
                $orderData['itemUnitCost' . $i] = number_format(number_format($product['price'], 2, '.', ''), 2, '.', '');
                $orderData['itemTotalAmount' . $i] = number_format($product['price'] * $product['quantity'], 2, '.', '');
            }
        }

        $orderData['itemCount'] = $i;
        $orderData['userAgent'] = $_SERVER['HTTP_USER_AGENT'];

        return $orderData;

    }

    public function getCountryCode($country = 'BR')
    {
        return isset($this->_countryCodes[$country]) ? $this->_countryCodes[$country] : 'BR';
    }    

    private function hideXMLSensitiveInformation($xml)
    {
        $xml = preg_replace('/<number>(.*)<\/number>/m', '<number>*****</number>', $xml);
        $xml = preg_replace('/<cvvNumber>(.*)<\/cvvNumber>/m', '<cvvNumber>***</cvvNumber>', $xml);
        $xml = preg_replace('/<token>(.*)<\/token>/m', '<token>***</token>', $xml);

        return $xml;
    }

    public function getSavedCards($canSave, $customerId = null)
    {
        $saved_cards = array();
        if ($canSave && $customerId) {
            //Saved Cards
            $sql = 'SELECT *
                    FROM ' . DB_PREFIX . 'maxipago_cc_token
                    WHERE `id_customer` = \'' . $customerId . '\'';
            $saved_cards = $this->db->query($sql);
        }

        return $saved_cards;
    }
}
