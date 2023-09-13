<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_miniorange_saml
 * @author     miniOrange Security Software Pvt. Ltd. <info@xecurify.com>
 * @copyright  Copyright 2015 miniOrange. All Rights Reserved.
 * @license    GNU/GPLv3
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');
jimport('joomla.filesystem.file');


/**
 * Myaccount controller class.
 *
 * @since  1.6
 */
class Miniorange_samlControllerMyaccount extends JControllerForm
{
    function __construct()
    {
        $this->view_list = 'myaccounts';
        parent::__construct();
    }

    function requestForTrialPlan()
    {
        $post = JFactory::getApplication()->input->post->getArray();
        if ((!isset($post['email'])) || (!isset($post['plan'])) || (!isset($post['description']))) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=request_demo',JText::_('COM_MINIORANGE_SAML_MSG_A'), 'error');
            return;
        }
        $email = $post['email'];
        $plan = $post['plan'];
        $description = trim($post['description']);
        $demo = 'Trial';
        if ( empty($email) ||empty($plan) || empty($description)) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=request_demo', JText::_('COM_MINIORANGE_SAML_MSG_A'), 'error');
            return;
        }

        $customer = new Mo_saml_Local_Customer();
        $response = json_decode($customer->request_for_trial($email, $plan, $demo, $description));

        if ($response->status != 'ERROR')
        {
            $msg=($demo == 'Demo')? JText::_('COM_MINIORANGE_SAML_MSG_B'):JText::_('COM_MINIORANGE_SAML_MSG_C');
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=request_demo', $msg);
        }
        else {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=request_demo',JText::_('COM_MINIORANGE_SAML_MSG_D'), 'error');
            return;
        }

    }

    function verifyCustomer()
    {
        $post = JFactory::getApplication()->input->post->getArray();
        if ((!isset($post['email'])) || (!isset($post['password']))) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account');
            return;
        }

        $email = '';
        $password = '';

        if (Mo_Saml_Local_Util::check_empty_or_null($post['email']) || Mo_Saml_Local_Util::check_empty_or_null($post['password'])) {
            JFactory::getApplication()->enqueueMessage(JText::_('COM_MINIORANGE_SAML_MSG_A'), 'error');
            return;
        } else {
            $email = $post['email'];
            $password = $post['password'];
        }


        $customer = new Mo_saml_Local_Customer();
        $content = $customer->get_customer_key($email, $password);

        $customerKey = json_decode($content, true);

        if (strcasecmp($customerKey['apiKey'], 'CURL_ERROR') == 0) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', $customerKey['token'], 'error');
            return;
        } else if (json_last_error() == JSON_ERROR_NONE) {
            $this->saveSuccessCustomer($customerKey, JText::_('COM_MINIORANGE_SAML_MSG_E'), $email);
        } else {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_F'), 'error');
            return;
        }
    }

    function saveSuccessCustomer($customerKey, $message, $email = '')
    {
        if (empty($email)) {
            $email = isset($customerKey['email']) ? $customerKey['email'] : '';
        }
        $apiKey = isset($customerKey['apiKey']) ? $customerKey['apiKey'] : '';
        $token = isset($customerKey['token']) ? $customerKey['token'] : '';
        $phone = isset($customerKey['phone']) ? $customerKey['phone'] : '';
        $customerId = isset($customerKey['id']) ? $customerKey['id'] : '';
        $this->save_success_customer_config($email, $customerId, $apiKey, $token, $phone, $message);

    }

    function updateSPIssuerOrBaseUrl()
    {
        $post = JFactory::getApplication()->input->post->getArray();
        if ((!isset($post['sp_entity_id'])) || (!isset($post['sp_base_url']))) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=description');
            return;
        }

        $database_name = '#__miniorange_saml_config';
        $updatefieldsarray = array(
            'sp_entity_id' => trim($post['sp_entity_id']),
            'sp_base_url' => trim($post['sp_base_url']),
        );

        $result = new Mo_saml_Local_Util();
        $result->generic_update_query($database_name, $updatefieldsarray);
        $this->setRedirect('index.php?option=com_miniorange_saml&tab=description',JText::_('COM_MINIORANGE_SAML_MSG_G'));
    }

    function updateOrganizationDetails()
    {
        $post = JFactory::getApplication()->input->post->getArray();

        $database_name = '#__miniorange_saml_config';
        $updatefieldsarray = array(
            'organization_name' => trim($post['organization_name']),
            'organization_display_name' => trim($post['organization_display_name']),
            'organization_url' => trim($post['organization_url']),
            'tech_per_name' => trim($post['tech_per_name']),
            'tech_email_add' => trim($post['tech_email_add']),
            'support_per_name' => trim($post['support_per_name']),
            'support_email_add' => trim($post['support_email_add']),
        );

        $result = new Mo_saml_Local_Util();
        $result->generic_update_query($database_name, $updatefieldsarray);
        $this->setRedirect('index.php?option=com_miniorange_saml&tab=description',JText::_('COM_MINIORANGE_SAML_MSG_H'));

    }

    function save_success_customer_config($email, $id, $apiKey, $token, $phone, $msg)
    {
        $database_name = '#__miniorange_saml_customer_details';
        $updatefieldsarray = array(
            'email' => $email,
            'customer_key' => $id,
            'api_key' => $apiKey,
            'customer_token' => $token,
            'admin_phone' => $phone,
            'login_status' => 0,
            'registration_status' => 'SUCCESS',
            'password' => '',
            'email_count' => 0,
            'sms_count' => 0,
        );

        $result = new Mo_saml_Local_Util();
        $result->generic_update_query($database_name, $updatefieldsarray);
        $erMsg = JText::_('COM_MINIORANGE_SAML_MSG_E');
        $this->setRedirect('index.php?option=com_miniorange_saml&tab=licensing', $erMsg);
    }

    function customerLoginForm()
    {
        $database_name = '#__miniorange_saml_customer_details';
        $updatefieldsarray = array(
            'login_status' => 1,
            'password' => '',
            'sms_count' => 0,
        );

        $result = new Mo_saml_Local_Util();
        $result->generic_update_query($database_name, $updatefieldsarray);
        $this->setRedirect('index.php?option=com_miniorange_saml&tab=account');
    }

    function ResetAccount()
    {
        $database_name = '#__miniorange_saml_customer_details';
        $updatefieldsarray = array(
            'customer_key' => '',
            'api_key' => '',
            'customer_token' => '',
            'admin_phone' => '',
            'login_status' => 0,
            'new_registration' => 0,
            'registration_status' => NULL,
            'email' => '',
        );

        $result = new Mo_saml_Local_Util();
        $result->generic_update_query($database_name, $updatefieldsarray);
        $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',JText::_('COM_MINIORANGE_SAML_MSG_I'));
        return;
    }

    function handle_upload_metadata()
    {
        $post = JFactory::getApplication()->input->post->getArray();
        require_once JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'MetadataReader.php';
        $file = JFactory::getApplication()->input->files->getArray();
        if (isset($file['metadata_file']) || isset($post['metadata_url'])) {
            if (!empty($file['metadata_file']['tmp_name'])) {
                $file = @file_get_contents($file['metadata_file']['tmp_name']);
            } else {
                $url = filter_var($post['metadata_url'], FILTER_SANITIZE_URL);
                $arrContextOptions = array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                    ),
                );
                if (empty($url)) {
                    $this->setRedirect('index.php?option=com_miniorange_saml&tab=idp', JText::_('COM_MINIORANGE_SAML_MSG_J'), 'error');
                    return;
                } else {
                    $file = file_get_contents($url, false, stream_context_create($arrContextOptions));
                }
            }
            $this->upload_metadata($file);
        } else {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=idp');
            return;
        }
    }

    function upload_metadata($file)
    {
        $document = new DOMDocument();
        $document->loadXML($file);
        restore_error_handler();
        $first_child = $document->firstChild;
        if (!empty($first_child)) {
            $metadata = new IDPMetadataReader($document);
            $identity_providers = $metadata->getIdentityProviders();

            if (empty($identity_providers)) {
                $this->setRedirect('index.php?option=com_miniorange_saml&tab=idp', JText::_('COM_MINIORANGE_SAML_MSG_K'), 'error');
                return;
            }
            foreach ($identity_providers as $key => $idp) {
                $saml_login_url = $idp->getLoginURL('HTTP-Redirect');
                $saml_issuer = $idp->getEntityID();
                $saml_x509_certificate = $idp->getSigningCertificate();
                $database_name = '#__miniorange_saml_config';
                $updatefieldsarray = array(

                    'idp_entity_id' => isset($saml_issuer) ? $saml_issuer : 0,
                    'single_signon_service_url' => isset($saml_login_url) ? $saml_login_url : 0,
                    'name_id_format' => isset($name_id_format) ? $name_id_format : "urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress",
                    'binding' => 'HttpRedirect',
                    'certificate' => isset($saml_x509_certificate) ? $saml_x509_certificate[0] : 0,
                );

                $result = new Mo_saml_Local_Util();
                $result->generic_update_query($database_name, $updatefieldsarray);
                break;
            }
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=idp', JText::_('COM_MINIORANGE_SAML_MSG_L'));
            return;
        } else {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=idp', JText::_('COM_MINIORANGE_SAML_MSG_K'), 'error');
            return;
        }
    }

    function importexport()
    {
        $customer = new Mo_saml_Local_Util();
        $customerResult = $customer->_load_db_values('#__miniorange_saml_config');

        if (empty($customerResult['idp_entity_id']) || empty($customerResult['single_signon_service_url'])) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=com_miniorange_saml&tab=idp', JText::_('COM_MINIORANGE_SAML_MSG_M'), 'error');
            return;
        }
        $post = JFactory::getApplication()->input->post->getArray();
        require_once JPATH_SITE . DIRECTORY_SEPARATOR . 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_miniorange_saml' . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'export.php';

        define("Tab_Class_Names", serialize(array(
            "idp_info" => 'mo_idp_info',
            "attribute_mapping" => 'mo_attribute_mapping',
            "role_mapping" => 'mo_role_mapping',
            "proxy" => 'mo_proxy'
        )));

        $tab_class_name = unserialize(Tab_Class_Names);
        $configuration_array = array();
        foreach ($tab_class_name as $key => $value) {
            $configuration_array[$key] = $this->mo_get_configuration_array($value);
        }

        if ($configuration_array) {
            header("Content-Disposition: attachment; filename=miniorange-SP-config.json");
            echo(json_encode($configuration_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            exit;
        }
        if(isset($post) && $post['test_configuration']=='true')
        {
            $this->setRedirect('index.php??morequest=acs',  JText::_('COM_MINIORANGE_SAML_MSG_N'));
            return;
        }
        $this->setRedirect('index.php?option=com_miniorange_saml&tab=import_export',  JText::_('COM_MINIORANGE_SAML_MSG_N'));
        return;
    }

    function mo_get_configuration_array($class_name)
    {
        if ($class_name == 'mo_idp_info' || $class_name == 'mo_attribute_mapping') {
            $customerResult = SAML_Utilities::_get_values_from_table('#__miniorange_saml_config');
        }

        if ($class_name == 'mo_role_mapping') {
            $customerResult = SAML_Utilities::_get_values_from_table('#__miniorange_saml_role_mapping');
        }

        if ($class_name == 'mo_proxy') {
            $customerResult = SAML_Utilities::_get_values_from_table('#__miniorange_saml_proxy_setup');
        }

        $class_object = call_user_func($class_name . '::getConstants');
        $mo_array = array();

        foreach ($class_object as $key => $value) {
            if ($mo_option_exists = $customerResult[$value])
                $mo_array[$key] = $mo_option_exists;
        }
        return $mo_array;
    }
    function saveAdminMail()
    {
        $post=	JFactory::getApplication()->input->post->getArray();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $fields = array(
            $db->quoteName('email') . ' = '.$db->quote($post['admin_email']),

        );

        $conditions = array(
            $db->quoteName('id') . ' = 1'
        );

        $query->update($db->quoteName('#__miniorange_saml_customer_details'))->set($fields)->where($conditions);
        $db->setQuery($query);
        $result = $db->execute();
        $this->setRedirect('index.php?option=com_miniorange_saml&tab=com_miniorange_saml&tab=idp',JText::_('COM_MINIORANGE_SAML_MSG_O'));
        return;
    }
    function proxyConfig()
    {
        $post = JFactory::getApplication()->input->post->getArray();
        if (count($post) == 0) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account');
            return;
        }
        $database_name = '#__miniorange_saml_proxy_setup';
        $updatefieldsarray = array('proxy_host_name' => isset($post['mo_proxy_host']) ? $post['mo_proxy_host'] : 0,
            'port_number' => isset($post['mo_proxy_port']) ? $post['mo_proxy_port'] : 0,
            'username' => isset($post['mo_proxy_username']) ? $post['mo_proxy_username'] : 0,
            'password' => isset($post['mo_proxy_password']) ? $post['mo_proxy_password'] : 0
        );

        $proxy_setup = new Mo_saml_Local_Util();
        $proxy_setup->generic_update_query($database_name, $updatefieldsarray);

        //Save saml configuration
        $message = JText::_('COM_MINIORANGE_SAML_MSG_P');
        $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', $message);
    }

    function proxyConfigReset()
    {
        $database_name = '#__miniorange_saml_proxy_setup';
        $updatefieldsarray = array('proxy_host_name' => '', 'port_number' => '', 'username' => '', 'password' => '');
        $proxy_setup = new Mo_saml_Local_Util();
        $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
        $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',JText::_('COM_MINIORANGE_SAML_MSG_Q'));
    }

    function saveConfig()
    {
        ?>
        <script>
            function showTest() {
                var testconfigurl = window.location.href;
                testconfigurl = testconfigurl.substr(0, testconfigurl.indexOf('administrator')) + '?morequest=sso&q=test_config';
                var myWindow = window.open(testconfigurl, 'TEST SAML IDP', 'scrollbars=1 width=800, height=600');
            }
        </script>
        <?php
        $customer = new Mo_saml_Local_Util();
        $customerResult = $customer->_load_db_values('#__miniorange_saml_config');

        $post = JFactory::getApplication()->input->post->getArray();
        if (count($post) == 0) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=idp');
            return;
        }
        $updated_settings = isset($post['option1']) ? $post['option1'] : '';
        if ($updated_settings == "mo_saml_save_config") {
            $upload = isset($post['cert']) ? $post['cert'] : '';
            if ($upload == "upload_cert") {
                if ($_FILES["myFile"]["name"] != "") {
                    $cert_file_name = $_FILES["myFile"]["name"];
                    $cer_var = explode(".", $cert_file_name);
                    if ($cer_var[1] == 'cer' || $cer_var[1] == 'cert' || $cer_var[1] == 'crt') {
                        $tmp_file = $_FILES["myFile"]["tmp_name"];
                        $file_cert = file_get_contents($tmp_file);
                        $certificate = SAML_Utilities::sanitize_certificate($file_cert);
                        if (!@openssl_x509_read($certificate)) {
                            $message =JText::_('COM_MINIORANGE_SAML_MSG_R');
                            $this->setRedirect('index.php?option=com_miniorange_saml&tab=idp', $message, 'error');
                            return;
                        }

                    } else {
                        $message = JText::_('COM_MINIORANGE_SAML_MSG_S');
                        $this->setRedirect('index.php?option=com_miniorange_saml&tab=idp', $message, 'error');
                        return;
                    }
                } else {
                    $message = JText::_('COM_MINIORANGE_SAML_MSG_T');
                    $this->setRedirect('index.php?option=com_miniorange_saml&tab=idp', $message, 'error');
                    return;
                }
            } else {
                if (isset($post['certificate']) && (!empty($post['certificate']))) {
                    $certificate = SAML_Utilities::sanitize_certificate($post['certificate']);
                    if (!@openssl_x509_read($certificate)) {
                        $message = JText::_('COM_MINIORANGE_SAML_MSG_R');
                        $this->setRedirect('index.php?option=com_miniorange_saml&tab=idp', $message, 'error');
                        return;
                    }
                }
                else{
                    $certificate = $post['certificate'];
                }
            }

            $database_name = '#__miniorange_saml_config';
            $idp_entity_id = isset($post['idp_entity_id']) ? $post['idp_entity_id'] : '';
            $idp_entity_id = SAML_Utilities::sanitize_url($idp_entity_id);
            $updatefieldsarray = array(
                'idp_entity_id' => $idp_entity_id,
                'single_signon_service_url' => isset($post['single_signon_service_url']) ? $post['single_signon_service_url'] : '',
                'name_id_format' => isset($post['name_id_format']) ? $post['name_id_format'] : '',
                'login_link_check' => isset($post['login_link_check']) ? $post['login_link_check'] : '0',
                'dynamic_link' => isset($post['dynamic_link']) ? $post['dynamic_link'] : "Login with IDP",
                'binding' => 'HttpRedirect',
                'certificate' => isset($certificate) ? $certificate : '',
            );

            $result = new Mo_saml_Local_Util();
            $result->generic_update_query($database_name, $updatefieldsarray);

            //Save saml configuration
            $message = JText::_('COM_MINIORANGE_SAML_MSG_L');
            $status = 'success';
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=idp', $message);

        } else if ($updated_settings == "mo_saml_save_attribute") {
            $database_name = '#__miniorange_saml_config';
            $updatefieldsarray = array(
                'enable_email' => isset($post['enable_email']) ? $post['enable_email'] : 0,
                'username' => isset($post['username']) ? $post['username'] : 0,
                'email' => isset($post['email']) ? $post['email'] : 0,
                'name' => isset($post['name']) ? $post['name'] : 0,
                'grp' => isset($post['grp']) ? $post['grp'] : 0,
            );

            $result = new Mo_saml_Local_Util();
            $result->generic_update_query($database_name, $updatefieldsarray);

            //Save saml configuration
            $message = JText::_('COM_MINIORANGE_SAML_MSG_P');
            $status = 'success';
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=attribute_mapping', $message);
        }
    }

    public function saveRolemapping()
    {
        $post = JFactory::getApplication()->input->post->getArray();
        if (count($post) == 0) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=group_mapping');
            return;
        }
        $max_allowed_mappings = 100;
        $added_mappings_count = 0;
        $role_mapping_key_value = array();
        for ($i = 1; $i <= $max_allowed_mappings; $i++) {
            if (isset($post['mapping_key_' . $i])) {
                if ($post['mapping_key_' . $i] == "")
                    continue;
                $role_mapping_key_value[($post['mapping_key_' . $i])] = $post['mapping_value_' . $i];
                $added_mappings_count++;
            } else {
                break;
            }
        }

        $database_name = '#__miniorange_saml_role_mapping';
        $updatefieldsarray = array(
            'mapping_value_default' => $post['mapping_value_default'],
            'mapping_memberof_attribute' => isset($post['mapping_memberof_attribute']) ? $post['mapping_memberof_attribute'] : '',
            'enable_saml_role_mapping' => isset($post['enable_role_mapping']) ? $post['enable_role_mapping'] : 0,
            'role_mapping_key_value' => json_encode($role_mapping_key_value),
            'role_mapping_count' => $added_mappings_count,
        );

        $result = new Mo_saml_Local_Util();
        $result->generic_update_query($database_name, $updatefieldsarray);

        $result = new Mo_saml_Local_Util();
        $result = $result->_load_db_values('#__miniorange_saml_role_mapping');

        $enable_role_mapping = $result['enable_saml_role_mapping'];
        $statusMessage = JText::_('COM_MINIORANGE_SAML_MSG_P');
        $this->setRedirect('index.php?option=com_miniorange_saml&tab=group_mapping', '' . $statusMessage);
    }

    function registerCustomer()
    {
        //validate and sanitize
        $post = JFactory::getApplication()->input->post->getArray();
        if (count($post) == 0) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account');
            return;
        }
        $email = '';
        $phone = '';
        $password = '';
        $confirmPassword = '';
        if (Mo_Saml_Local_Util::check_empty_or_null($post['email']) || Mo_Saml_Local_Util::check_empty_or_null($post['password']) || Mo_Saml_Local_Util::check_empty_or_null($post['confirmPassword'])) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',JText::_('COM_MINIORANGE_SAML_MSG_A'), 'error');
            return;
        } else if (strlen($post['password']) < 6 || strlen($post['confirmPassword']) < 6) {    //check password is of minimum length 6
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_U'), 'error');
            return;
        } else {
            $email = $post['email'];
            $phone = $post['phone'];
            $password = $post['password'];
            $confirmPassword = $post['confirmPassword'];
        }

        $database_name = '#__miniorange_saml_customer_details';
        $updatefieldsarray = array(
            'email' => $email,
        );

        $proxy_setup = new Mo_saml_Local_Util();
        $proxy_setup->generic_update_query($database_name, $updatefieldsarray);

        if ($phone != '') {
            $database_name = '#__miniorange_saml_customer_details';
            $updatefieldsarray = array(
                'admin_phone' => $phone,
            );

            $proxy_setup = new Mo_saml_Local_Util();
            $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
        }

        if (strcmp($password, $confirmPassword) == 0) {
            $database_name = '#__miniorange_saml_customer_details';
            $updatefieldsarray = array(
                'password' => base64_encode($password),
            );

            $proxy_setup = new Mo_saml_Local_Util();
            $proxy_setup->generic_update_query($database_name, $updatefieldsarray);

            $customer = new Mo_saml_Local_Customer();
            $content = json_decode($customer->check_customer($email), true);
            if (strcasecmp($content['status'], 'CUSTOMER_NOT_FOUND') == 0) {
                $auth_type = 'EMAIL';
                $content = json_decode($customer->send_otp_token($auth_type, null), true);
                if (strcasecmp($content['status'], 'SUCCESS') == 0) {
                    $database_name = '#__miniorange_saml_customer_details';
                    $updatefieldsarray = array(
                        'email_count' => '1',
                        'transaction_id' => $content['txId'],
                        'registration_status' => 'MO_OTP_DELIVERED_SUCCESS',
                    );

                    $proxy_setup = new Mo_saml_Local_Util();
                    $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                    $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_V').' <strong>' . $email . '</strong> '.JText::_('COM_MINIORANGE_SAML_MSG_W'));
                } else {
                    $database_name = '#__miniorange_saml_customer_details';
                    $updatefieldsarray = array(
                        'registration_status' => 'MO_OTP_DELIVERED_FAILURE',
                    );

                    $proxy_setup = new Mo_saml_Local_Util();
                    $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                    $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_X'), 'error');
                    return;
                }
            } else if (strcasecmp($content['status'], 'CURL_ERROR') == 0) {
                $database_name = '#__miniorange_saml_customer_details';
                $updatefieldsarray = array(
                    'registration_status' => 'MO_OTP_DELIVERED_FAILURE',
                );

                $proxy_setup = new Mo_saml_Local_Util();
                $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', $content['statusMessage'], 'error');
                return;
            } else if (strcasecmp($content['status'], 'TRANSACTION_LIMIT_EXCEEDED') == 0) {
                $database_name = '#__miniorange_saml_customer_details';
                $updatefieldsarray = array(
                    'login_status' => 1,
                    'registration_status' => '',
                );

                $proxy_setup = new Mo_saml_Local_Util();
                $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',  JText::_('COM_MINIORANGE_SAML_MSG_Y'), 'error');
                return;
            } else {
                $content = $customer->get_customer_key($email, $password);
                $customerKey = json_decode($content, true);
                if (json_last_error() == JSON_ERROR_NONE) {
                    $this->saveSuccessCustomer($customerKey, JText::_('COM_MINIORANGE_SAML_MSG_E'), $email);

                    $database_name = '#__miniorange_saml_customer_details';
                    $updatefieldsarray = array('password' => '',);
                    $proxy_setup = new Mo_saml_Local_Util();
                    $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                } else {
                    $database_name = '#__miniorange_saml_customer_details';
                    $updatefieldsarray = array(
                        'login_status' => 1,
                        'new_registration' => 0,
                        'password' => '',
                    );

                    $proxy_setup = new Mo_saml_Local_Util();
                    $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                    $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_Z'), 'error');
                    return;
                }
            }
        } else {
            $database_name = '#__miniorange_saml_customer_details';
            $updatefieldsarray = array('login_status' => 0,);

            $proxy_setup = new Mo_saml_Local_Util();
            $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',  JText::_('COM_MINIORANGE_SAML_MSG_1'), 'error');
            return;
        }
    }

    function validateOtp()
    {
        //validation and sanitization
        $post = JFactory::getApplication()->input->post->getArray();

        if (!isset($post['otp_token'])) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account');
            return;
        }
        $otp_token = '';

        if (Mo_Saml_Local_Util::check_empty_or_null($post['otp_token'])) {

            $database_name = '#__miniorange_saml_customer_details';
            $updatefieldsarray = array('registration_status' => 'MO_OTP_VALIDATION_FAILURE',);
            $proxy_setup = new Mo_saml_Local_Util();
            $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',JText::_('COM_MINIORANGE_SAML_MSG_2'), 'error');
            return;
        } else {
            $otp_token = trim($post['otp_token']);
        }

        $transaction_detail = new Mo_saml_Local_Util();
        $transaction_id = $transaction_detail->_load_db_values('#__miniorange_saml_customer_details');

        $transaction_id = $transaction_id['transaction_id'];

        $customer = new Mo_saml_Local_Customer();


        $content = json_decode($customer->validate_otp_token($transaction_id, $otp_token), true);

        if (strcasecmp($content['status'], 'SUCCESS') == 0) {
            $customer = new Mo_saml_Local_Customer();
            $customerKey = json_decode($customer->create_customer(), true);
            $database_name = '#__miniorange_saml_customer_details';
            $updatefieldsarray = array(
                'email_count' => 0,
                'sms_count' => 0,
            );
            $proxy_setup = new Mo_saml_Local_Util();
            $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
            if (strcasecmp($customerKey['status'], 'CUSTOMER_USERNAME_ALREADY_EXISTS') == 0) {    //admin already exists in miniOrange
                $content = $customer->get_customer_key($transaction_id['email'], $transaction_id['password']);
                $customerKey = json_decode($content, true);
                if (json_last_error() == JSON_ERROR_NONE) {
                    $this->saveSuccessCustomer($customerKey, JText::_('COM_MINIORANGE_SAML_MSG_3'), '');
                } else {
                    $database_name = '#__miniorange_saml_customer_details';
                    $updatefieldsarray = array(
                        'registration_status' => 'false',
                        'login_status' => 1,
                        'password' => '',
                    );
                    $proxy_setup = new Mo_saml_Local_Util();
                    $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                    $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',JText::_('COM_MINIORANGE_SAML_MSG_Z'), 'error');
                    return;
                }
            } else if (strcasecmp($customerKey['status'], 'INVALID_EMAIL') == 0) {
                $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',JText::_('COM_MINIORANGE_SAML_MSG_4'), 'error');
                return;
            } else if (strcasecmp($customerKey['status'], 'SUCCESS') == 0) {
                $database_name = '#__miniorange_saml_customer_details';
                $updatefieldsarray = array(
                    'password' => '',
                );
                $proxy_setup = new Mo_saml_Local_Util();
                $proxy_setup->generic_update_query($database_name, $updatefieldsarray);

                //registration successful
                $this->saveSuccessCustomer($customerKey, 'Registration complete!', '');
            } else if (strcmp($customerKey['message'], 'Email is not enterprise email.') == 0) {
                $database_name = '#__miniorange_saml_customer_details';
                $updatefieldsarray = array(
                    'registration_status' => '',
                    'email' => '',
                    'password' => '',
                    'transaction_id' => '',
                );
                $proxy_setup = new Mo_saml_Local_Util();
                $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_5'), 'error');
                return;
            } else {
                $database_name = '#__miniorange_saml_customer_details';
                $updatefieldsarray = array(
                    'registration_status' => '',
                    'email' => '',
                    'password' => '',
                    'transaction_id' => '',
                );
                $proxy_setup = new Mo_saml_Local_Util();
                $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_5'), 'error');
                return;
            }
        } else if (strcasecmp($content['status'], 'INVALID_EMAIL_QUICK_EMAIL') == 0) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_5'), 'error');
            return;
        } else if ($content['status'] == 'FAILED') {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_6'), 'error');
            return;
        } else if (strcasecmp($content['status'], 'CURL_ERROR') == 0) {
            $database_name = '#__miniorange_saml_customer_details';
            $updatefieldsarray = array(
                'registration_status' => 'MO_OTP_VALIDATION_FAILURE',
            );

            $proxy_setup = new Mo_saml_Local_Util();
            $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', $content['statusMessage'], 'error');
            return;
        } else {
            $database_name = '#__miniorange_saml_customer_details';
            $updatefieldsarray = array(
                'registration_status' => 'MO_OTP_VALIDATION_FAILURE',
            );

            $proxy_setup = new Mo_saml_Local_Util();
            $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',JText::_('COM_MINIORANGE_SAML_MSG_7'), 'error');
            return;
        }
    }

    function resendOtp()
    {
        $customer = new Mo_saml_Local_Customer();
        $auth_type = 'EMAIL';
        $content = json_decode($customer->send_otp_token($auth_type, null), true);
        if (strcasecmp($content['status'], 'SUCCESS') == 0) {
            $customer_details = (new Mo_saml_Local_Util)->_load_db_values('#__miniorange_saml_customer_details');
            $email_count = $customer_details['email_count'];
            $admin_email = $customer_details['email'];
            if ($email_count != '') {
                $email_count = $email_count + 1;
                $database_name = '#__miniorange_saml_customer_details';
                $updatefieldsarray = array(
                    'email_count' => $email_count,
                    'transaction_id' => $content['txId'],
                    'registration_status' => 'MO_OTP_DELIVERED_SUCCESS',
                );

                $proxy_setup = new Mo_saml_Local_Util();
                $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_8'). '<strong>' . ($admin_email) . '</strong>. '. JText::_('COM_MINIORANGE_SAML_MSG_9'));
            } else {
                $database_name = '#__miniorange_saml_customer_details';
                $updatefieldsarray = array('registration_status' => 'MO_OTP_DELIVERED_SUCCESS',);
                $proxy_setup = new Mo_saml_Local_Util();
                $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',JText::_('COM_MINIORANGE_SAML_MSG_8'). '<strong>' . ($admin_email) . '</strong>. '. JText::_('COM_MINIORANGE_SAML_MSG_9'));
            }
        } else if (strcasecmp($content['status'], 'CURL_ERROR') == 0) {
            $database_name = '#__miniorange_saml_customer_details';
            $updatefieldsarray = array('registration_status' => 'MO_OTP_DELIVERED_FAILURE',);
            $proxy_setup = new Mo_saml_Local_Util();
            $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', $content['statusMessage'], 'error');
            return;
        } else {
            $database_name = '#__miniorange_saml_customer_details';
            $updatefieldsarray = array('registration_status' => 'MO_OTP_DELIVERED_FAILURE',);
            $proxy_setup = new Mo_saml_Local_Util();
            $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_X'), 'error');
            return;
        }
    }

    function cancelform()
    {
        $database_name = '#__miniorange_saml_customer_details';
        $updatefieldsarray = array('email' => '',
            'registration_status' => '',
            'login_status' => 0,
            'email_count' => 0,
            'sms_count' => 0,
        );

        $proxy_setup = new Mo_saml_Local_Util();
        $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
        $this->setRedirect('index.php?option=com_miniorange_saml&tab=account');
    }

    function phoneVerification()
    {
        $post = JFactory::getApplication()->input->post->getArray();
        if (count($post) == 0) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account');
            return;
        }
        $phone = $post['phone_number'];
        $phone = str_replace(' ', '', $phone);
        $pattern = "/[\+][0-9]{1,3}[0-9]{10}/";
        if (preg_match($pattern, $phone, $matches, PREG_OFFSET_CAPTURE)) {
            $auth_type = 'SMS';
            $customer = new Mo_saml_Local_Customer();
            $send_otp_response = json_decode($customer->send_otp_token($auth_type, $phone));
            if ($send_otp_response->status == 'SUCCESS') {
                $sms_count = new Mo_saml_Local_Util();
                $sms_count = $sms_count->_load_db_values('#__miniorange_saml_customer_details');
                $sms_count = $sms_count['sms_count'];
                if ($sms_count != '') {
                    $sms_count = $sms_count + 1;
                    $database_name = '#__miniorange_saml_customer_details';
                    $updatefieldsarray = array('sms_count' => $sms_count,
                        'transaction_id' => $send_otp_response->txId,
                    );
                    $proxy_setup = new Mo_saml_Local_Util();
                    $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                    $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_10').'<strong>(' . $sms_count . ')</strong> '. JText::_('COM_MINIORANGE_SAML_MSG_11'). $phone);
                } else {
                    $database_name = '#__miniorange_saml_customer_details';
                    $updatefieldsarray = array('sms_count' => 1,
                        'transaction_id' => $send_otp_response->txId,
                    );
                    $proxy_setup = new Mo_saml_Local_Util();
                    $proxy_setup->generic_update_query($database_name, $updatefieldsarray);
                    $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',JText::_('COM_MINIORANGE_SAML_MSG_12') .' ' . $phone);
                }
            }
            else if( $send_otp_response->status =='FAILED') {
                $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_13'), 'error');
                return;
            }
        } else {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',JText::_('COM_MINIORANGE_SAML_MSG_14'), 'error');
            return;
        }
    }

    function contactUs()
    {
        $post = JFactory::getApplication()->input->post->getArray();
        if (count($post) == 0) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account');
            return;
        }
        if (isset($post['query_phone']) && $post['query_phone'] != NULL) {
            $pgone_num_validate = preg_match("/^\+?[0-9]+$/", $post['query_phone']);
            if (!$pgone_num_validate) {
                $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',JText::_('COM_MINIORANGE_SAML_MSG_15') , 'error');
                return;
            }
        }

        if (Mo_saml_Local_Util::check_empty_or_null($post['query_email'])) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_16'), 'error');
            return;
        } else if (Mo_saml_Local_Util::check_empty_or_null(trim($post['mo_saml_query_support'] || trim($post['mo_saml_query_support'])))) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_20'), 'error');
            return;
        } else {
            $query = $post['mo_saml_query_support'];
            $email = $post['query_email'];
            $phone = $post['query_phone'];
            $contact_us = new Mo_saml_Local_Customer();
            $submited = $contact_us->submit_contact_us($email, $phone, $query);
            if (json_last_error() == JSON_ERROR_NONE) {
                if (is_array($submited) && array_key_exists('status', $submited) && $submited['status'] == 'ERROR') {
                    $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', $submited['message'], 'error');
                    return;
                } else {
                    if ($submited == false) {
                        $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_17') , 'error');
                        return;
                    } else {
                        $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',  JText::_('COM_MINIORANGE_SAML_MSG_18'));
                    }
                }
            }
        }
    }

    function callContactUs()
    {
        $post = JFactory::getApplication()->input->post->getArray();
        if (count($post) == 0) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account');
            return;
        }
        $query_email = $post['mo_sp_setup_call_email'];
        $query = $post['mo_sp_setup_call_issue'];
        $description = $post['mo_sp_setup_call_desc'];
        $callDate = $post['mo_sp_setup_call_date'];
        $timeZone = $post['mo_sp_setup_call_timezone'];
        if ($this->checkEmptyOrNull($timeZone) || $this->checkEmptyOrNull($callDate) || $this->checkEmptyOrNull($query_email) || $this->checkEmptyOrNull($query) || $this->checkEmptyOrNull($description)) {
            $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_19'), 'error');
            return;
        } else {
            $contact_us = new Mo_saml_Local_Customer();
            $submited = $contact_us->request_for_setupCall($query_email, $query, $description, $callDate, $timeZone);
            if (json_last_error() == JSON_ERROR_NONE) {
                if (is_array($submited) && array_key_exists('status', $submited) && $submited['status'] == 'ERROR') {
                    $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', $submited['message'], 'error');
                } else {
                    if ($submited == false) {
                        $this->setRedirect('index.php?option=com_miniorange_saml&tab=account', JText::_('COM_MINIORANGE_SAML_MSG_17'), 'error');
                    } else {
                        $this->setRedirect('index.php?option=com_miniorange_saml&tab=account',JText::_('COM_MINIORANGE_SAML_MSG_18'));
                    }
                }
            }

        }
    }

    function checkEmptyOrNull($value)
    {
        if (!isset($value) || empty($value)) {
            return true;
        }
        return false;
    }
}
