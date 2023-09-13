<?php
defined('_JEXEC') or die;
/*
 * @package    miniOrange
 * @subpackage Plugins
 * @license    GNU/GPLv3
 * @copyright  Copyright 2015 miniOrange. All Rights Reserved.
*/

JHtml::_('jquery.framework');
JHtml::_('stylesheet', JUri::base() .'components/com_miniorange_saml/assets/css/mo_saml_style.css');
JHtml::_('stylesheet', JUri::base() . 'components/com_miniorange_saml/assets/css/bootstrap-select-min.css');
JHtml::_('stylesheet', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
JHtml::_('stylesheet', JUri::base() . 'components/com_miniorange_saml/assets/css/miniorange_boot.css');
JHtml::_('script', JUri::base() . 'components/com_miniorange_saml/assets/js/samlUtility.js');
JHtml::_('script', JUri::base() . 'components/com_miniorange_saml/assets/js/bootstrap-select-min.js');
JHtml::_('script', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js');

if (!Mo_Saml_Local_Util::is_curl_installed())
{
?>
    <div id="help_curl_warning_title" class="mo_saml_title_panel">
        <p><a target="_blank" style="cursor: pointer;"><span class="mo_saml_required"><?php echo JText::_('COM_MINIORANGE_SAML_CURL_WARNING'); ?></span> <?php echo JText::_('COM_MINIORANGE_SAML_CURL_SPAN'); ?></a></p>
    </div>
    <div hidden="" id="help_curl_warning_desc" class="mo_saml_help_desc">
        <?php echo JText::_('COM_MINIORANGE_SAML_LIST'); ?>
        <?php echo JText::_('COM_MINIORANGE_SAML_CONTACT'); ?>
    </div>
    <?php
}

$tab = "overview";
$get = JFactory::getApplication()->input->get->getArray();
$test_config = isset($get['test-config']) ? true: false;
if (isset($get['tab']) && !empty($get['tab']))
{
    $tab = $get['tab'];
}
?>
<?php
    $saml_configuration=SAML_Utilities::_get_values_from_table('#__miniorange_saml_config');
    $session = JFactory::getSession();
    $session->set('show_test_config', false);
    if($test_config)
    {
        $session->set('show_test_config', true);
    }
    if($saml_configuration['show_tc_popup']==false)
    {
        echo "
        <script>
            jQuery(document).ready(function(){
                show_TC_modal();
            });
        </script>
        ";
        $database_name = '#__miniorange_saml_config';
        $updatefieldsarray = array(
            'show_tc_popup' => true,
        );
        Mo_saml_Local_Util::generic_update_query($database_name, $updatefieldsarray);
    }


?>

    <div class="mo_boot_row" style="width:100%!important">
        <div class="mo_boot_col-lg-11 ">
            <div class="nav-tab-wrapper mo_idp_nav-tab-wrapper ">

                <a id="overviewtab"  class="mo_nav-tab <?php echo $tab == 'overview' ? 'mo_nav_tab_active' : ''; ?>" href="#overview_plugin"
                onclick="add_css_tab('#overviewtab');" 
                data-toggle="tab" ><?php echo JText::_('COM_MINIORANGE_SAML_SP_OVERVIEW'); ?>
                </a>

                <a id="idptab"  class="mo_nav-tab <?php echo $tab == 'idp' ? 'mo_nav_tab_active' : ''; ?>" href="#identity-provider"
                onclick="add_css_tab('#idptab');" 
                data-toggle="tab" ><?php echo JText::_('COM_MINIORANGE_SAML_IDP'); ?>
                </a>

                <a id="descriptiontab" class="mo_nav-tab <?php echo $tab == 'description' ? 'mo_nav_tab_active' : ''; ?>" href="#description"
                onclick="add_css_tab('#descriptiontab');"
                data-toggle="tab" ><?php echo JText::_('COM_MINIORANGE_SAML_DESCRIPTION'); ?>
                </a>

                <a id="sso_login" class="mo_nav-tab <?php echo $tab == 'sso_settings' ? 'mo_nav_tab_active' : ''; ?>" href="#sso_settings"
                onclick="add_css_tab('#sso_login');"
                data-toggle="tab"><?php echo JText::_('COM_MINIORANGE_SAML_LOGINSETTINGS'); ?>
                </a>

                <a id="attributemappingtab" class="mo_nav-tab <?php echo $tab == 'attribute_mapping' ? 'mo_nav_tab_active' : ''; ?>" href="#attribute-mapping"
                onclick="add_css_tab('#attributemappingtab');"
                data-toggle="tab"><?php echo JText::_('COM_MINIORANGE_SAML_ATTRIBUTEMAPPING'); ?>
                </a>

                <a id="groupmappingtab" class="mo_nav-tab <?php echo $tab == 'group_mapping' ? 'mo_nav_tab_active' : ''; ?>" href="#group-mapping"
                onclick="add_css_tab('#groupmappingtab');"
                data-toggle="tab"><?php echo JText::_('COM_MINIORANGE_SAML_GROUPMAPPING'); ?>
                </a>

                <a id="custcert" class="mo_nav-tab <?php echo $tab == 'ccert' ? 'mo_nav_tab_active' : ''; ?>" href="#ccert"
                onclick="add_css_tab('#custcert');"
                data-toggle="tab"><?php echo JText::_('COM_MINIORANGE_SAML_SP_CUSTOMCRT'); ?>
                </a>

                <a id="licensingtab" class="mo_nav-tab <?php echo $tab == 'licensing' ? 'mo_nav_tab_active' : ''; ?>" href="#licensing-plans"
                onclick="add_css_tab('#licensingtab');"
                data-toggle="tab" style="background-color: orange !important;"><?php echo JText::_('COM_MINIORANGE_SAML_LICENSING'); ?>
                </a>

                <a id="registrationtab" class="mo_nav-tab <?php echo $tab == 'account' ? 'mo_nav_tab_active' : ''; ?>" href="#account"
                onclick="add_css_tab('#registrationtab');"
                data-toggle="tab"><?php echo JText::_('COM_MINIORANGE_SAML_ACCOUNT'); ?>
                </a>

                

            </div>
        </div>
        <div class="mo_boot_col-lg-1">
        <button id="mo_TC"  onclick="show_TC_modal()" style=" float: right; margin-right:10px;padding: 7px !important" class="mo_boot_btn mo_boot_btn-saml">T&C</button>
        <div id="my_TC_Modal" class="TC_modal">
            <div class="TC_modal-content">
                <div class="mo_boot_row">
                    <div class="mo_boot_col-12 mo_boot_text-center">
                        <span style="font-size: 28px;"><strong><?php echo JText::_('COM_MINIORANGE_SAML_TC'); ?></strong></span>
                        <span class="TC_modal_close" onclick="close_TC_modal()">&times;</span>
                    </div>
                    
                </div>
                    <hr>
                    <ul> 
                        <?php echo JText::_('COM_MINIORANGE_SAML_TC_LIST'); ?>
                        <li>
                            <form method="post" name="f" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.saveAdminMail'); ?>" > 
                                <?php
                                    $dVar=new JConfig(); 
                                    $check_email = $dVar->mailfrom;
                                    $result       = (new Mo_saml_Local_Util)->_load_db_values('#__miniorange_saml_customer_details');
                                    
                                    if($result['email']!=NULL)
                                    {
                                        $check_email =$result['email'];
                                    }
                                ?>
                                <div class="mo_boot_row mo_boot_mt-3">
                                    <div class="mo_boot_col-sm-5">
                                        <input type="email" name="admin_email"  class="mo_boot_form-control" value="<?php echo $check_email;?>">
                                    </div>
                                    <div class="mo_boot_col-sm-3">
                                        <input type="submit" class="mo_boot_btn mo_boot_btn-primary" value=" <?php echo JText::_('COM_MINIORANGE_SAML_TC_BTN'); ?>">
                                    </div>
                                </div>                            
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </div>
   
    <div class="mo_boot_row" style="background-color:#e0e0d8;">
        <div class="mo_boot_col-sm-12">
            <div class="tab-content" id="myTabContent">
                <div id="overview_plugin" class="tab-pane <?php if ($tab == 'overview') echo 'active'; ?> ">
                    <?php common_classes('show_plugin_overview','mo_saml_local_support');?>
                </div>
                
                <div id="account" class="tab-pane <?php if ($tab == 'account') echo 'active'; ?> ">
                    <?php common_classes('account_tab','mo_saml_local_support');?>
                </div>

                <div id="description" class="tab-pane <?php if ($tab == 'description') echo 'active'; ?> ">
                    <?php common_classes_for_UI('description', 'mo_saml_local_support','mo_saml_adv_pagerestriction');?>
                </div>

                <div id="sso_settings" class="tab-pane <?php if ($tab == 'sso_settings') echo 'active'; ?>">
                    <?php common_classes_for_UI('mo_sso_login','mo_saml_local_support','mo_saml_adv_net');?>
                </div>

                <div id="identity-provider" class="tab-pane <?php if ($tab == 'idp') echo 'active'; ?>">
                    <?php common_classes('select_identity_provider', 'mo_saml_local_support');?>
                </div>

                <div id="attribute-mapping" class="tab-pane <?php if ($tab == 'attribute_mapping') echo 'active'; ?>">
                    <?php common_classes_for_UI('attribute_mapping','mo_saml_local_support','mo_saml_adv_idp');?>
                </div>

                <div id="group-mapping" class="tab-pane <?php if ($tab == 'group_mapping') echo 'active'; ?>">
                    <?php common_classes_for_UI('group_mapping','mo_saml_local_support','mo_saml_adv_loginaudit');?>
                </div>

                <div id="proxy-setup" class="tab-pane <?php if ($tab == 'proxy_setup') echo 'active'; ?>">
                    <?php common_classes_for_UI('proxy_setup', 'mo_saml_local_support','mo_saml_advertise');?>
                </div>

                <div id="request-demo" class="tab-pane <?php if ($tab == 'request_demo') echo 'active'; ?>">
                    <?php common_classes('requestfordemo', 'mo_saml_advertise');?>
                </div>
                    
                <div id="licensing-plans" class="tab-pane <?php if ($tab == 'licensing') echo 'active'; ?>">
                    <div class="row-fluid">
                        <table style="width:100%;">
                            <caption></caption>
                            <tr>
                                <th id="s"></th>
                            </tr>
                            <tr>
                                <td style="width:65%;vertical-align:top;" class="configurationForm">
                                    <?php Licensing_page(); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div id="ccert" class="tab-pane <?php if ($tab == 'ccert') echo 'active'; ?>">
                    <?php common_classes('customcertificate', 'mo_saml_local_support');?>
                </div>

                
            </div>
        </div>
    </div>
        
<?php function common_classes_for_UI($tab_func, $support_func, $add_func)
{
    ?>
    <div class="mo_boot_row mo_boot_px-4 mo_boot_py-3">
        <div class="mo_boot_col-sm-8">
            <div>
                <?php
                    $tab_func();
                ?>
            </div>
        </div>
        <div class="mo_boot_col-sm-4">
            <div id="mo_saml_support1" >
                <?php
                $support_func();
                ?>
            </div>
        <div id="mo_saml_support2" class="mo_boot_py-3">
                <?php
                    $add_func();
                ?>
            </div>
        </div>
    </div>
    <?php
}

function common_classes($tab_func, $support_func)
{
    ?>
    <div class="mo_boot_row mo_boot_px-4 ">
        <div class="mo_boot_col-sm-8 mo_boot_py-3 ">
            <div>
                <?php
                    $tab_func();
                ?>
            </div>
        </div>
        <div class="mo_boot_col-sm-4 " >
            <div id="mo_saml_support1" class="mo_boot_py-3">
                <?php
                    $support_func();
                    ?>
                </div>
            </div>
        </div>
    <?php
}
?>

<?php

function account_tab()
{
    ?>
   <div class="mo_boot_row mo_boot_m-0 mo_boot_p-0" id="registrationForm">
    <?php
            $customer_details = (new Mo_saml_Local_Util)->_load_db_values('#__miniorange_saml_customer_details');
            $login_status = $customer_details['login_status'];
            $registration_status = $customer_details['registration_status'];
            if ($login_status)
            {
                mo_saml_local_login_page();
            }
            else if ($registration_status == 'MO_OTP_DELIVERED_SUCCESS' || $registration_status == 'MO_OTP_VALIDATION_FAILURE' || $registration_status == 'MO_OTP_DELIVERED_FAILURE')
            {
                mo_saml_local_show_otp_verification();
            }
            else if (!Mo_Saml_Local_Util::is_customer_registered())
            {
                mo_saml_local_registration_page();
            }
            else
            {
                mo_saml_local_account_page();
            }
        ?>
    </div>
    <?php
}

function mo_saml_local_login_page()
{
    ?>
    <div class="mo_boot_row  mo_boot_mr-1 mo_boot_p-3 mo_tab_border">
        <div class="mo_boot_col-sm-12">
            <form name="f" method="post" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.verifyCustomer'); ?>">
                <div class="mo_boot_row mo_boot_mt-2">
                    <div class="mo_boot_col-sm-12">
                        <input type="hidden" name="option1" value="mo_saml_local_verify_customer" />
                        <h3><?php echo JText::_('COM_MINIORANGE_SAML_LOGIN_HEADING'); ?></h3><hr>
                        <p><?php echo JText::_('COM_MINIORANGE_SAML_LOGIN_EXPLANATION'); ?></p>
                    </div>
                </div>
                <div id="panel1" style="align:center!important;">
                    <div class="mo_boot_row mo_boot_mt-2">
                        <div class="mo_boot_col-sm-3 mo_boot_offset-sm-1">
                            <strong><em class="mo_saml_required">*</em>   <?php echo JText::_('COM_MINIORANGE_SAML_EMAIL'); ?>:</strong>
                        </div>
                        <div class="mo_boot_col-sm-6">
                            <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="email" name="email" required placeholder="person@example.com" value="" />
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_mt-2">
                        <div class="mo_boot_col-sm-3 mo_boot_offset-sm-1">
                            <strong><em class="mo_saml_required">*</em>    <?php echo JText::_('COM_MINIORANGE_SAML_PASSWORD'); ?>:</strong>
                        </div>
                        <div class="mo_boot_col-sm-6">
                            <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" required type="password" name="password" placeholder="   <?php echo JText::_('COM_MINIORANGE_SAML_PASS_PLACEHOLDER'); ?>" />
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_mt-2">
                        <div class="mo_boot_col-sm-12 mo_boot_text-center">
                            <input type="submit" class="mo_boot_btn mo_boot_btn-saml mo_boot_mt-1" value="<?php echo JText::_('COM_MINIORANGE_SAML_LOGIN_BTN'); ?>"/>
                            <input type="button" value="<?php echo JText::_('COM_MINIORANGE_SAML_BACK_REGISTRATION'); ?>" onclick="moSAMLCancelForm();" class="mo_boot_btn mo_boot_btn-danger mo_boot_mt-1" />
                            <a href="https://login.xecurify.com/moas/idp/resetpassword" target="_blank"  class="mo_boot_btn mo_boot_btn-saml mo_boot_mt-1 anchor_tag"><?php echo JText::_('COM_MINIORANGE_SAML_FOROGET_PASS_BTN'); ?></a>
                        </div>
                    </div>
                </div>
            </form>
            <form id="cancel_form" method="post" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.cancelform'); ?>">
                <input type="hidden" name="option1" value="mo_saml_local_cancel" />
            </form>
        </div>
    </div>
    <?php
    }

    function show_plugin_overview()
    {
        ?>
        <div class="mo_boot_row mo_boot_mr-1 mo_boot_p-3 mo_tab_border">
            <div class="mo_boot_col-12">
                <h3><?php echo JText::_('COM_MINIORANGE_SAML_OVERVIEW_TAB'); ?></h3><hr>
            </div>
            <div class="mo_boot_col-12">
                <?php 
                    if(MoConstants::MO_SAML_SP=='ALL')
                    {
                        echo JText::_('COM_MINIORANGE_SAML_IDP_ALL');
                    }else if(MoConstants::MO_SAML_SP=='ADFS')
                    {
                        echo JText::_('COM_MINIORANGE_SAML_SP_ADFS');
                    }else if(MoConstants::MO_SAML_SP=='GOOGLEAPPS')
                    {
                        echo JText::_('COM_MINIORANGE_SAML_SP_GOOGLE_APPS');
                    }
                ?>
                </p>
            </div>
        </div>
        <?php
    }

    function mo_saml_local_account_page()
    {
        $result = new Mo_saml_Local_Util();
        $result = $result->_load_db_values('#__miniorange_saml_customer_details');
        $email = $result['email'];
        $customer_key = $result['customer_key'];
        $api_key = $result['api_key'];
        $customer_token = $result['customer_token'];
        $hostname = Mo_Saml_Local_Util::getHostname();
        $joomla_version=SAML_Utilities::getJoomlaCmsVersion();
        $phpVersion = phpversion();
        $PluginVersion = SAML_Utilities::GetPluginVersion();
        ?>
        <div class="mo_boot_row mo_boot_mr-1 mo_boot_p-3 mo_tab_border" id="cum_pro">
            <div class="mo_boot_col-sm-12 mo_saml_welcome_message">
                <h4><?php echo JText::_('COM_MINIORANGE_SAML_REGISTRAION_MSG'); ?></h4>
            </div>
            <div class="mo_boot_col-sm-12 table-responsive mo_boot_mt-3">
                <table class="table table-striped table-hover table-bordered ">
                <tr>
                    <td class="mo_profile_td_h"><?php echo JText::_('COM_MINIORANGE_SAML_USERNAME'); ?></td>
                    <td class="mo_profile_td"><?php echo $email ?></td>
                </tr>
                <tr>
                    <td class="mo_profile_td_h"><?php echo JText::_('COM_MINIORANGE_SAML_CUSTOMER_ID'); ?></td>
                    <td class="mo_profile_td"><?php echo $customer_key ?></td>
                </tr>
                <tr>
                    <td class="mo_profile_td_h"><?php echo JText::_('COM_MINIORANGE_SAML_JVERSION'); ?></td>
                    <td class="mo_profile_td"><?php echo  $joomla_version ?></td>
                </tr>
                <tr>
                    <td class="mo_profile_td_h"><?php echo JText::_('COM_MINIORANGE_SAML_PHP_VERSION'); ?></td>
                    <td class="mo_profile_td"><?php echo  $phpVersion ?></td>
                </tr>
                <tr>
                    <td class="mo_profile_td_h"><?php echo JText::_('COM_MINIORANGE_SAML_PLUGIN_VERSION'); ?></td>
                    <td class="mo_profile_td"><?php echo $PluginVersion ?></td>
                </tr>
            </table>
            </div>
            <div class="mo_boot_col-sm-12 mo_boot_text-center" id="sp_proxy_setup">
                <input id="sp_proxy" type="button" class='mo_boot_btn mo_boot_btn-saml mo_boot_d-inline-block' onclick='show_proxy_form()' value="<?php echo JText::_('COM_MINIORANGE_SAML_PROXY'); ?>"/>
                <form class="mo_boot_d-inline-block" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.ResetAccount'); ?>" name="reset_useraccount" method="post">
                    <input type="button"  value="<?php echo JText::_('COM_MINIORANGE_SAML_RM_ACCOUNT'); ?>" onclick='submit();' class="mo_boot_btn mo_boot_btn-danger"  /> <br/>
                </form>
            </div>
        </div>
        <div class="mo_boot_row mo_tab_border" id="submit_proxy" style=" display:none ;" >
            <?php proxy_setup() ?>
        </div>
        <?php
    }

/* Show OTP verification page*/
function mo_saml_local_show_otp_verification()
{
    ?>
    <div id="panel2" class="mo_boot_p-4 mo_tab_border" >
        <form name="f" method="post" id="idp_form" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.validateOtp'); ?>">
            <div class="mo_boot_row">
                <div class="mo_boot_col-sm-12">
                    <input type="hidden" name="option1" value="mo_saml_local_validate_otp" />
                    <h3><?php echo JText::_('COM_MINIORANGE_SAML_VERIFY_EMAIL'); ?></h3>
                    <hr>
                </div>
            </div>
            <div class="mo_boot_row">
                <div class="mo_boot_col-sm-2">
                    <strong><span class="mo_saml_required">*</span><?php echo JText::_('COM_MINIORANGE_SAML_ENTER_OTP'); ?>:</strong>
                </div>
                <div class="mo_boot_col-sm-6">
                    <input class="mo_boot_form-control" autofocus="true" type="text" name="otp_token" required placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_ENTER_OTP'); ?>"/>
                </div>
                <div class="mo_boot_col-sm-4">
                    <a style="cursor:pointer;" class="mo_boot_btn mo_boot_btn-primary" onclick="document.getElementById('resend_otp_form').submit();"><?php echo JText::_('COM_MINIORANGE_SAML_RESEND_OTP_EMAIL'); ?></a>
                </div>
            </div>
            <div class="mo_boot_row">
                <div class="mo_boot_col-sm-12 mo_boot_text-center"><br>
                    <input type="submit" value="<?php echo JText::_('COM_MINIORANGE_SAML_VALIDATE_OTP'); ?>" class="mo_boot_btn mo_boot_btn-success"/>
                    <input type="button" value="<?php echo JText::_('COM_MINIORANGE_SAML_BACK'); ?>" class="mo_boot_btn mo_boot_btn-danger" onclick="moSAMLBack();"/>
                </div>
            </div>
        </form>

        <form method="post" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.cancelform'); ?>" id="mo_saml_cancel_form">
            <input type="hidden" name="option1" value="mo_saml_local_cancel" />
        </form>

        <form name="f" id="resend_otp_form" method="post" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.resendOtp'); ?>">
            <input type="hidden" name="option1" value="mo_saml_local_resend_otp"/>
        </form>
        <hr>
        <div class="mo_boot_row">
            <div class="mo_boot_col-sm-12">
                <h3><?php echo JText::_('COM_MINIORANGE_SAML_OTP_NOT_RECIEVED'); ?></h3>
            </div>
        </div>
        <form id="phone_verification" method="post" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.phoneVerification'); ?>">
                <div class="mo_boot_row">
                    <div class="mo_boot_col-sm-12">
                        <input type="hidden" name="option1" value="mo_saml_local_phone_verification" />
                        <p><?php echo JText::_('COM_MINIORANGE_SAML_OTP_MESSAGE'); ?></p>

                    </div>
                </div>
                <div class="mo_boot_row">
                    <div class="mo_boot_col-sm-8">
                        <input class="mo_boot_form-control" required="true" pattern="[\+]\d{1,3}\d{10}" autofocus="true" type="text"
                        name="phone_number" id="phone" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_PHONE_PLACEHOLDER'); ?>"  />
                    </div>
                    <div class="mo_boot_col-sm-4">
                        <input type="submit" value="<?php echo JText::_('COM_MINIORANGE_SAML_VERIFY_PHONE'); ?>" class="mo_boot_btn mo_boot_btn-primary"/>
                    </div>
                </div>
        </form>
    </div>

    <?php
}
/* End Show OTP verification page*/
/* Create Customer function */
function mo_saml_local_registration_page()
{
    $database_name = '#__miniorange_saml_customer_details';
    $updatefieldsarray = array(
        'new_registration' => 1,
    );
    $result = new Mo_saml_Local_Util();
    $result->generic_update_query($database_name, $updatefieldsarray);
    ?>

    <!--Register with miniOrange-->
    <div class="mo_boot_row  mo_boot_mr-1 mo_boot_p-3 mo_tab_border" id="submit_proxy" style="display:none;">
        <div class="mo_boot_col-sm-12">
            <?php 
                proxy_setup() 
            ?>
        </div>
    </div>
    <div class="mo_boot_row  mo_boot_mr-1 mo_boot_p-3 mo_tab_border" id="panel1">
        <div class="mo_boot_col-sm-12">
            <form name="f" method="post" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.registerCustomer'); ?>">
                <div class="mo_boot_row mo_boot_mt-3">
                    <div class="mo_boot_col-lg-7  mo_boot_mt-1">
                        <input type="hidden" name="option1" value="mo_saml_local_register_customer" />
                        <h3><?php echo JText::_('COM_MINIORANGE_SAML_REGISTER_HEADER'); ?></h3>
                    </div>
                    <div class="mo_boot_col-lg-5  mo_boot_mt-1">
                        <input type="button" value="<?php echo JText::_('COM_MINIORANGE_SAML_ALREADY_REGISTER'); ?>" class="mo_boot_btn mo_boot_btn-saml" style="float:right" onclick="mo_login_page();"/>
                    </div>
                </div>
                <hr/>
                <div class="mo_boot_row">
                    <div class="mo_boot_col-sm-12">
                        <h4><?php echo JText::_('COM_MINIORANGE_SAML_WHY_REGISTER'); ?></h4>
                        <p class='mo_saml_notes'><?php echo JText::_('COM_MINIORANGE_SAML_REASON_RESTRATION'); ?></p><br>
                        <p style="color: #fa2727"><?php echo JText::_('COM_MINIORANGE_SAML_REGISTER_HELP'); ?></p>
                    </div>
                </div><br>
                <div id="spregister" class="mo_saml_settings_table">
                    <div class="mo_boot_row" id="spemail">
                        <div class="mo_boot_col-sm-3">
                            <strong><?php echo JText::_('COM_MINIORANGE_SAML_EMAIL'); ?><em class="mo_saml_required">*</em>:</strong>
                        </div>
                        <div class="mo_boot_col-sm-8">
                            <?php 
                                $current_user = JFactory::getUser();
                                $result = new Mo_saml_Local_Util();
                                $result = $result->_load_db_values('#__miniorange_saml_customer_details');
                                $admin_email = $result['email'];
                                $admin_phone = $result['admin_phone'];
                                if ($admin_email == '')
                                {
                                    $admin_email = $current_user->email;
                                }
                            ?>
                            <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="email" name="email" placeholder="person@example.com" required value="<?php echo $admin_email; ?>" />
                        </div>
                    </div><br>
                    <div class="mo_boot_row" id="sprg_phone">
                        <div class="mo_boot_col-sm-3">
                            <strong><?php echo JText::_('COM_MINIORANGE_SAML_PHONE_NUMBER'); ?>:</strong>
                        </div>
                        <div class="mo_boot_col-sm-8">
                            <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="tel" id="phone" pattern="[\+]\d{11,14}|[\+]\d{1,4}([\s]{0,1})(\d{0}|\d{9,10})" name="phone" title="<?php echo JText::_('COM_MINIORANGE_SAML_PHONE_PLACEHOLDER'); ?>"  placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_PHONE_PLACEHOLDER'); ?>" value="<?php echo $admin_phone; ?>" />
                            <p><em><?php echo JText::_('COM_MINIORANGE_SAML_CALL_SUPPORT'); ?></em></p>
                        </div>
                    </div>
                    <div class="mo_boot_row" id="sprg_passwd">
                        <div class="mo_boot_col-sm-3">
                            <strong><?php echo JText::_('COM_MINIORANGE_SAML_PASSWORD'); ?><em class="mo_saml_required">*</em>:</strong>
                        </div>
                        <div class="mo_boot_col-sm-8">
                            <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup"  required  type="password" name="password" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_PASSWORD_CONDITION'); ?>" />
                        </div>
                    </div><br>
                    <div class="mo_boot_row" id="rg_repasswd">
                        <div class="mo_boot_col-sm-3">
                            <strong><?php echo JText::_('COM_MINIORANGE_SAML_CONFIRM_PASS'); ?><em class="mo_saml_required">*</em>:</strong>
                        </div>
                        <div class="mo_boot_col-sm-8">
                            <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup"  required type="password" name="confirmPassword" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_CONFIRM_PASS_PH'); ?>" />
                        </div>
                    </div>
                    <div class="mo_boot_row">
                        <div class="mo_boot_col-sm-12 mo_boot_text-center">
                            <input type="submit" value="Register" class="mo_boot_btn mo_boot_btn-saml" />
                            <div class="mo_boot_d-inline-block" id="sp_proxy_setup"><br>
                                <input id="sp_proxy" type="button" class='mo_boot_btn mo_boot_btn-saml' onclick='show_proxy_form_one()' value="<?php echo JText::_('COM_MINIORANGE_SAML_PROXY'); ?>"/>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form name="f" id="customer_login_form" method="post" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.customerLoginForm'); ?> ">
            </form>
        </div>
    </div>
    <?php
}

function description()
{
    $siteUrl = JURI::root();
    $sp_base_url = '';

    $result = (new Mo_saml_Local_Util)->_load_db_values('#__miniorange_saml_config');
    $sp_entity_id = isset($result['sp_entity_id']) ? $result['sp_entity_id'] : '';

    if($sp_entity_id == ''){
        $sp_entity_id = $siteUrl . 'plugins/authentication/miniorangesaml';
    }

    if(isset($result['sp_base_url'])){
        $sp_base_url = $result['sp_base_url'];
    }

    if (empty($sp_base_url))
        $sp_base_url = $siteUrl;

    $org_name=$result['organization_name'];
    $org_dis_name=$result['organization_display_name'];
    $org_url=$result['organization_url'];
    $tech_name=$result['tech_per_name'];
    $tech_email=$result['tech_email_add'];
    $support_name=$result['support_per_name'];
    $support_email=$result['support_email_add'];

    ?>
        <div class="mo_boot_row  mo_boot_mr-1  mo_boot_p-3 mo_tab_border">
            <div class="mo_boot_col-sm-12 mo_boot_mt-3">
                <div class="mo_boot_row">
                    <div class="mo_boot_col-lg-10 mo_boot_mt-1">
                        <h3><?php echo JText::_('COM_MINIORANGE_SAML_SP_METADATA'); ?> <sup><a href="https://developers.miniorange.com/docs/joomla/saml-sso/saml-service-provider-metadata" target="_blank" class="mo_saml_know_more" title="<?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>"><div class="fa fa-question-circle-o"></div></a></sup></h3>
                    </div>
                </div><hr>
            </div>
            <div class="mo_boot_col-sm-12 mo_boot_mt-3">
                <h3 style="color: #d9534f;"><?php echo JText::_('COM_MINIORANGE_SAML_UPDATE_ENTITY'); ?></h3><br>
                <form action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.updateSPIssuerOrBaseUrl'); ?>" method="post" name="updateissueer" id="identity_provider_update_form">
                    <div class="mo_boot_row">
                        <div class="mo_boot_col-sm-3">
                            <strong><span class="mo_saml_required">*</span><?php echo JText::_('COM_MINIORANGE_SAML_ISSUER'); ?> <div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext"><?php echo JText::_('COM_MINIORANGE_SAML_ISSUE_NOTE'); ?></span></div></strong>
                        </div>
                        <div class="mo_boot_col-sm-8">
                            <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="text" name="sp_entity_id" value="<?php echo $sp_entity_id; ?>" required />
                            <br>
                        </div>

                        <div class="mo_boot_col-sm-3">
                            <strong><span class="mo_saml_required">*</span><?php echo JText::_('COM_MINIORANGE_SAML_BASE_URL'); ?></strong>
                        </div>
                        <div class="mo_boot_col-sm-8">
                            <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="text" name="sp_base_url" value="<?php echo $sp_base_url; ?>" required />
                        </div>
                    </div>
                    <div class="mo_boot_row">
                        <div class="mo_boot_col-sm-12 mo_boot_text-center"><br>
                            <input type="submit" class="mo_boot_btn mo_boot_btn-success" value="<?php echo JText::_('COM_MINIORANGE_SAML_UPDATE_BTN'); ?>"/>
                        </div>
                    </div>
                </form><hr>
            </div>
            
        
            <div  id="metadata" class="mo_boot_col-sm-12  mo_boot_mt-2">
                <p style="color: #d9534f;"><?php echo JText::_('COM_MINIORANGE_SAML_METADATA_NOTE'); ?></p>
                <p  class="mo_boot_mt-3"><?php echo JText::_('COM_MINIORANGE_SAML_METADATA_FIRST'); ?></p>
        
                <div class="mo_boot_col-sm-12  mo_boot_mt-2 mo_boot_table-responsive">
                    <div class="mo_saml_highlight_background_url_note">
                        <div class="mo_boot_row">
                            <div class="mo_boot_col-10">
                                <strong><?php echo JText::_('COM_MINIORANGE_SAML_METADATA_URL'); ?> :
                                    <span id="idp_metadata_url" >
                                        <a  href='<?php echo $sp_base_url . '?morequest=metadata'; ?>' id='metadata-linkss' target='_blank'><?php echo '<strong>' . $sp_base_url . '?morequest=metadata </strong>'; ?></a>
                                    </span>  
                                </strong>
                            </div>
                            <div class="mo_boot_col-2">
                                <em class="fa fa-lg fa-copy mo_copy_sso_url mo_copytooltip" onclick="copyToClipboard('#idp_metadata_url');" ><span class="mo_copytooltiptext copied_text"><?php echo JText::_('COM_MINIORANGE_SAML_COPY_BTN'); ?></span></em>
                            </div>
                        </div>
                    </div>
             
                </div>
            
                <div class="mo_boot_col-sm-12 mo_boot_mt-2">
                    <p id="mo_download_metadata" class="mo_boot_mt-3">
                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_METADATA_FILE'); ?> :</strong>
                        <a href="<?php echo $sp_base_url . '?morequest=download_metadata'; ?>" class="mo_boot_btn mo_boot_btn-saml anchor_tag">
                            <?php echo JText::_('COM_MINIORANGE_SAML_METADATA_BTN'); ?>
                        </a>
                    </p>
                    <h2 style="text-align: center"><?php echo JText::_('COM_MINIORANGE_SAML_OR'); ?></h2>
                </div>
                <p  class="mo_boot_mt-3">
                    <strong><?php echo JText::_('COM_MINIORANGE_SAML_METADATA_SEC'); ?></strong>
                </p>
                <div id="mo_other_idp" style="overflow-x: scroll; ">
                    <table class='customtemp'>
                        <tr>
                            <td class="mo_table_td_style"><?php echo JText::_('COM_MINIORANGE_SAML_ISSUER'); ?></td>
                            <td><span id="entidy_id"><?php echo $sp_entity_id; ?></span>
                                <em class="fa fa-pull-right  fa-lg fa-copy mo_copy mo_copytooltip" 
                                    onclick="copyToClipboard('#entidy_id');"><span class="mo_copytooltiptext copied_text"><?php echo JText::_('COM_MINIORANGE_SAML_COPY_BTN'); ?></span></em>
                            </td>
                        </tr>
                        <tr>
                            <td class="mo_table_td_style"><?php echo JText::_('COM_MINIORANGE_SAML_ASC'); ?></td>
                            <td>
                                <span id="acs_url"><?php echo $sp_base_url . '?morequest=acs'; ?></span>
                                <em class="fa fa-pull-right  fa-lg fa-copy mo_copy mo_copytooltip" onclick="copyToClipboard('#acs_url');"><span class="mo_copytooltiptext copied_text"><?php echo JText::_('COM_MINIORANGE_SAML_COPY_BTN'); ?></span> </em>
                            </td>
                        </tr>
                        <tr>
                            <td class="mo_table_td_style"><?php echo JText::_('COM_MINIORANGE_SAML_AUDIENCE'); ?></td>
                            <td>
                                <span id="audience_url"><?php echo $sp_entity_id; ?></span>
                                <em class="fa fa-pull-right  fa-lg fa-copy mo_copy mo_copytooltip"
                                    onclick="copyToClipboard('#audience_url');" ><span class="mo_copytooltiptext copied_text"><?php echo JText::_('COM_MINIORANGE_SAML_COPY_BTN'); ?></span></em>
                            </td>
                        </tr>
                        <tr>
                            <td class="mo_table_td_style"><?php echo JText::_('COM_MINIORANGE_SAML_NAMEID_FORMAT'); ?></td>
                            <td>
                                <span id="name_id_format">urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified</span>
                                <em class="fa fa-pull-right  fa-lg fa-copy mo_copy mo_copytooltip"
                                    onclick="copyToClipboard('#name_id_format');"><span class="mo_copytooltiptext copied_text"><?php echo JText::_('COM_MINIORANGE_SAML_COPY_BTN'); ?></span> <em>
                            </td>
                        </tr>
                        <tr>
                            <td class="mo_table_td_style"><?php echo JText::_('COM_MINIORANGE_SAML_SLO'); ?></td>
                            <td>
                            
                                <?php echo JText::_('COM_MINIORANGE_SAML_AVAILABLE'); ?> <strong><a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Premium</strong></a>, <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Enterprise</strong></a></strong> <?php echo JText::_('COM_MINIORANGE_SAML_VERSIONS'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td ><?php echo JText::_('COM_MINIORANGE_SAML_DEFAULT_REALY'); ?></td>
                            <td>
                                <?php echo JText::_('COM_MINIORANGE_SAML_AVAILABLE'); ?> <strong><a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Standard</strong></a>, <strong><a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Premium</strong></a>, <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Enterprise</strong></a></strong> <?php echo JText::_('COM_MINIORANGE_SAML_VERSIONS'); ?>
                            </td>
                        </tr>

                    
                        <tr>
                            <td style="font-weight:bold;padding: 15px;"><b><?php echo JText::_('COM_MINIORANGE_SAML_PROXY'); ?>Certificate (Optional)</b></td>
                            <td>
                                <?php echo JText::_('COM_MINIORANGE_SAML_AVAILABLE'); ?> <strong><a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Standard</strong></a>, <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Premium</strong></a>, <a href='#' class='premium'><strong>Enterprise</strong></a></strong> <?php echo JText::_('COM_MINIORANGE_SAML_VERSIONS'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <hr>
            </div>
         
        <div class=" mo_boot_col-sm-12 mo_boot_mt-3">
            <div class="mo_boot_row">
                <div><h3 style="color: #d9534f;"><?php echo JText::_('COM_MINIORANGE_SAML_ORG_DETAILS'); ?></h3></div>
                <div><strong style="margin-left:10px;"> 
                    <a href='#' class='premium' onclick="moSAMLUpgrade();">[Standard,</a>
                    <a href='#' class='premium' onclick="moSAMLUpgrade();">Premium,</a>
                    <a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise]</a>
                </strong></div><br>
                </div>
                <form action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.updateOrganizationDetails'); ?>" method="post" name="updateorg" id="custmize_organization">
                    <div class="mo_boot_row">
                        <div class="mo_boot_col-sm-12 ">
                            <details !important open>
                                <summary class="mo_saml_summary"!important>
                                    <strong><?php echo JText::_('COM_MINIORANGE_SAML_ORG'); ?></strong>
                                </summary><hr>
                                <div class="mo_boot_row mo_boot_ml-3">
                                    <div class="mo_boot_col-sm-3">
                                        <strong> <?php echo JText::_('COM_MINIORANGE_SAML_ORG_NAME'); ?><span class="mo_saml_required">*</span> :</strong>
                                    </div>
                                    <div class="mo_boot_col-sm-8">
                                        <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="text" name="organization_name" value="<?php echo $org_name; ?>" required disabled/>
                                    </div><br><br>
                                    <div class="mo_boot_col-sm-3">
                                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_DIS_NAME'); ?><span class="mo_saml_required" >*</span> :</strong>
                                    </div>
                                    <div class="mo_boot_col-sm-8">
                                        <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="text"  name="organization_display_name" value="<?php echo $org_dis_name; ?>" required  disabled/>
                                    </div><br><br>
                                    <div class="mo_boot_col-sm-3">
                                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_ORG_URL'); ?><span class="mo_saml_required" >*</span> :</strong>
                                    </div>
                                    <div class="mo_boot_col-sm-8">
                                        <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="text" name="organization_url" value="<?php echo $org_url; ?>" required  disabled/>
                                    </div>
                                </div><br>
                            </details>
                        </div>
                        <div class="mo_boot_col-sm-12 ">
                            <details !important>
                                <summary class="mo_saml_summary">
                                    <strong><?php echo JText::_('COM_MINIORANGE_SAML_TECH_CONTACT'); ?></strong>
                                </summary><hr>
                                <div class="mo_boot_row mo_boot_ml-3">
                                    <div class="mo_boot_col-sm-3">
                                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_PERSON'); ?><span class="mo_saml_required">*</span> :</strong>
                                    </div>
                                    <div class="mo_boot_col-sm-8">
                                        <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="text" name="tech_per_name" value="<?php echo $tech_name; ?>" required   disabled/>
                                    </div><br><br>
                                    <div class="mo_boot_col-sm-3">
                                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_PERSON_EMAIL'); ?><span class="mo_saml_required">*</span> :</strong>
                                    </div>
                                    <div class="mo_boot_col-sm-8">
                                        <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="text" name="tech_email_add" value="<?php echo $tech_email; ?>" required  disabled/>
                                    </div>
                                </div><br>
                            </details>
                        </div>
                                
                        <div class="mo_boot_col-sm-12">
                            <details !important>
                                <summary class="mo_saml_summary" !important>
                                    <strong><?php echo JText::_('COM_MINIORANGE_SAML_SUPPORT_CONTACT'); ?></strong>
                                </summary><hr>
                                <div class="mo_boot_row mo_boot_ml-3">
                                    <div class="mo_boot_col-sm-3">
                                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_PERSON'); ?><span class="mo_saml_required">*</span> :</strong>
                                    </div><br><br>
                                    <div class="mo_boot_col-sm-8">
                                        <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="text" name="support_per_name"  value="<?php echo $support_name; ?>" required  disabled />
                                    </div>
                                    <div class="mo_boot_col-sm-3">
                                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_PERSON_EMAIL'); ?><span class="mo_saml_required">*</span> :</strong>
                                    </div>
                                    <div class="mo_boot_col-sm-8">
                                        <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="text" name="support_email_add" value="<?php echo $support_email; ?>" required  disabled/>
                                    </div>
                                </div>
                            </details>
                        </div>         
                            
                        <div class="mo_boot_col-sm-12 mo_boot_text-center"><br>
                            <input type="submit" class="mo_boot_btn mo_boot_btn-success" value="<?php echo JText::_('COM_MINIORANGE_SAML_UPDATE_BTN'); ?>" disabled/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
       
    <?php
}

function Licensing_page()
{
	$useremail = new Mo_saml_Local_Util();
	$useremail = $useremail->_load_db_values('#__miniorange_saml_customer_details');
    if (isset($useremail)) $user_email = $useremail['email'];
    else $user_email = "xyz";
    ?>
    <div id="myModal" class="TC_modal">
        <div class="TC_modal-content" style="width: 40%!important;">
            <span class="TC_modal_close" onclick="hidemodal()" >&times;</span><br><br>
            <div class=" mo_boot_text-center">
                <p>
                    <?php echo JText::_('COM_MINIORANGE_SAML_REGISTER_POPUP'); ?>
                </p><br><br>
                <a href="<?php echo JURI::base()?>index.php?option=com_miniorange_saml&tab=account" class="mo_boot_btn mo_boot_btn-primary"><?php echo JText::_('COM_MINIORANGE_SAML_REGISTER_BTN'); ?></a>
            </div>
        </div>
    </div>
    <div class="mo_boot_row mo_boot_m-4 mo_boot_mb-4">
        <div class="tab-content" >
            <div class="mo_boot_col-sm-12 mo_licensing_page_div">
                <div id="navbar">
                    <div class="mo_boot_row mo_license_navbar" >
                        <div class="mo_boot_col-sm-3 mo_boot_mt-3">  <strong><a href="#licensing_plans" id="plans-section" class="mo_navbar-links mo_license_navbar_links"> <?php echo JText::_('COM_MINIORANGE_SAML_NAV_PLAN'); ?></a></strong></div>
                        <div class="mo_boot_col-sm-3 mo_boot_mt-3">  <strong><a href="#addonContent" id="addon-section" class="mo_navbar-links mo_license_navbar_links" > <?php echo JText::_('COM_MINIORANGE_SAML_NAV_ADDONS'); ?></a></strong></div>
                        <div class="mo_boot_col-sm-3 mo_boot_mt-3">  <strong><a href="#upgrade-steps" id="upgrade-section" class="mo_navbar-links mo_license_navbar_links"> <?php echo JText::_('COM_MINIORANGE_SAML_NAV_STEPS'); ?></a></strong></div>
                        <div class="mo_boot_col-sm-3 mo_boot_mt-3">  <strong><a href="#payment-method" id="payment-section" class="mo_navbar-links mo_license_navbar_links" > <?php echo JText::_('COM_MINIORANGE_SAML_NAV_PAYMENT_METHODS'); ?></a></strong></div>   
                    </div>
                </div>
          
                <div class="mo_boot_m-2 mo_boot_text-center">
                    <h2> <?php echo JText::_('COM_MINIORANGE_SAML_CHOOSE_PLAN'); ?></h2>
                    <label class="mo_switch "  style=" text-align: center !important;">
                        <input type="checkbox" id="bundle_checked" onclick="show_bundle()" />
                        <span class="mo_slider mo_round"></span>
                    </label>
                </div>
                <div class="mo_boot_m-5 mo_boot_text-center" style="display:none;background-color:#ecf2f2;"  id="bundle_content">
                    <div class="mo_boot_col-sm-12">
                        <div class="mo_boot_row">
                            <div class="mo_boot_col-sm-4 mo_boot_p-4">
                                <div class="mo_boot_row mo_boot_p-2 mo_license_bundle_plan">
                                    <div class="mo_boot_col-sm-8 mo_boot_p-5 mo_boot_bg-light">
                                        <h3>
                                            <strong>Joomla SAML SP Standard</strong><br>
                                            <strong>+</strong><br>
                                            <strong>Joomla SCIM Premium</strong>
                                        </h3>
                                    </div>
                                    <div class="mo_boot_col-sm-4 mo_boot_p-3" style="background:#226a8b">
                                        <h3 style="color:white">
                                            <strong>$249</strong><br>
                                            <strong>+</strong><br>
                                            <strong>$249</strong><br><br>
                                            <strong><del style="color:orange">$498</del><br>$449</strong>
                                        </h3>
                                        <a href="https://www.miniorange.com/contact" target="_blank" class="mo_boot_mt-3 mo_boot_btn mo_boot_btn-success mo_verticle_center"><?php echo JText::_('COM_MINIORANGE_SAML_CONTACT_US'); ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="mo_boot_col-sm-4 mo_boot_p-4">
                                <div class="mo_boot_row mo_boot_p-2 mo_license_bundle_plan">
                                    <div class="mo_boot_col-sm-8 mo_boot_p-5 mo_boot_bg-light">
                                        <h3>
                                            <strong>Joomla SAML SP Premium</strong><br>
                                            <strong>+</strong><br>
                                            <strong>Joomla SCIM Premium</strong>
                                        </h3>
                                    </div>
                                    <div class="mo_boot_col-sm-4 mo_boot_p-3" style="background:#226a8b">
                                        <h3 style="color:white">
                                            <strong>$399</strong><br>
                                            <strong>+</strong><br>
                                            <strong>$249</strong><br><br>
                                            <strong><del style="color:orange">$648</del><br>$599</strong>
                                        </h3>
                                        <a href="https://www.miniorange.com/contact" target="_blank" class="mo_boot_mt-3 mo_boot_btn mo_boot_btn-success mo_verticle_center"><?php echo JText::_('COM_MINIORANGE_SAML_CONTACT_US'); ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="mo_boot_col-sm-4 mo_boot_p-4">
                                <div class="mo_boot_row mo_boot_p-2 mo_license_bundle_plan">
                                    <div class="mo_boot_col-sm-8 mo_boot_p-5 mo_boot_bg-light">
                                        <h3>
                                            <strong>Joomla SAML SP Enterprise</strong><br>
                                            <strong>+</strong><br>
                                            <strong>Joomla SCIM Premium</strong>
                                        </h3>
                                    </div>
                                    <div class="mo_boot_col-sm-4 mo_boot_p-3" style="background:#226a8b">
                                        <h3 style="color:white">
                                            <strong>$449</strong><br>
                                            <strong>+</strong><br>
                                            <strong>$249</strong><br><br>
                                            <strong><del style="color:orange">$698</del><br>$649</strong>
                                        </h3>
                                        <a href="https://www.miniorange.com/contact" target="_blank" class="mo_boot_mt-3 mo_boot_btn mo_boot_btn-success mo_verticle_center"><?php echo JText::_('COM_MINIORANGE_SAML_CONTACT_US'); ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="mo_boot_col-sm-4 mo_boot_p-4"  >
                                <div class="mo_boot_row mo_boot_p-2 mo_license_bundle_plan">
                                    <div class="mo_boot_col-sm-8 mo_boot_p-5 mo_boot_bg-light">
                                        <h3>
                                            <strong>Joomla SAML SP Standard</strong><br>
                                            <strong>+</strong><br>
                                            <strong>Joomla Page and Article Restriction Premium</strong>
                                        </h3>
                                    </div>
                                    <div class="mo_boot_col-sm-4 mo_boot_p-3" style="background:#226a8b">
                                        <h3 style="color:white">
                                            <strong>$249</strong><br>
                                            <strong>+</strong><br>
                                            <strong>$199</strong><br><br>
                                            <strong><del style="color:orange">$448</del><br>$399</strong>
                                        </h3>
                                        <a href="https://www.miniorange.com/contact" target="_blank" class="mo_boot_mt-3 mo_boot_btn mo_boot_btn-success  mo_verticle_center"><?php echo JText::_('COM_MINIORANGE_SAML_CONTACT_US'); ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="mo_boot_col-sm-4 mo_boot_p-4">
                                <div class="mo_boot_row mo_boot_p-2 mo_license_bundle_plan">
                                    <div class="mo_boot_col-sm-8 mo_boot_p-5 mo_boot_bg-light">
                                        <h3>
                                            <strong>Joomla SAML SP Premium</strong><br>
                                            <strong>+</strong><br>
                                            <strong>Joomla Page and Article Restriction Premium</strong>
                                        </h3>
                                    </div>
                                    <div class="mo_boot_col-sm-4 mo_boot_p-3" style="background:#226a8b">
                                        <h3 style="color:white">
                                            <strong>$399</strong><br>
                                            <strong>+</strong><br>
                                            <strong>$199</strong><br><br>
                                            <strong><del style="color:orange">$598</del><br>$549</strong>
                                        </h3>
                                        <a href="https://www.miniorange.com/contact" target="_blank" class="mo_boot_mt-3 mo_boot_btn mo_boot_btn-success mo_verticle_center"><?php echo JText::_('COM_MINIORANGE_SAML_CONTACT_US'); ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="mo_boot_col-sm-4 mo_boot_p-4">
                                <div class="mo_boot_row mo_boot_p-2 mo_license_bundle_plan">
                                    <div class="mo_boot_col-sm-8 mo_boot_p-5 mo_boot_bg-light">
                                        <h3>
                                            <strong>Joomla SAML SP Enterprise</strong><br>
                                            <strong>+</strong><br>
                                            <strong>Joomla Page and Article Restriction Premium</strong>
                                        </h3>
                                    </div>
                                    <div class="mo_boot_col-sm-4 mo_boot_p-3" style="background:#226a8b">
                                        <h3 style="color:white">
                                            <strong>$449</strong><br>
                                            <strong>+</strong><br>
                                            <strong>$199</strong><br><br>
                                            <strong><del style="color:orange">$648</del><br>$599</strong>
                                        </h3>
                                        <a href="https://www.miniorange.com/contact" target="_blank" class="mo_boot_mt-3 mo_boot_btn mo_boot_btn-success mo_verticle_center"><?php echo JText::_('COM_MINIORANGE_SAML_CONTACT_US'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="licensing_plans">
                    <div class="tab-pane active" style="  background-color:#ecf2f2;" id="license_content"  >
                        <div class="cd-pricing-container cd-has-margins"><br>
                            <ul class="cd-pricing-list cd-bounce-invert" >
                                <li class="cd-black">
                                    <ul class="cd-pricing-wrapper" >
                                        <li id="singlesite_tab" data-type="singlesite" class="mosslp is-visible cd-singlesite">
                                            <header class="cd-pricing-header">
                                                <h2 style="margin-bottom: 10px" >Basic</h2><span class="mo_saml_plan_description"><strong>( <?php echo JText::_('COM_MINIORANGE_SAML_BASIC'); ?>)</strong></span>
                                            </header> 
                                            <div style="text-align:center;display:none">
                                                <span id="plus_total_price" class="plus_total_price">$99*</span><br><span class="mo_saml_note"><strong>[ <?php echo JText::_('COM_MINIORANGE_SAML_ONE_TIME'); ?>]</strong></span>
                                            </div>
                                        
                                            <footer class="cd-pricing-footer">
                                            <?php
                                                if (!Mo_Saml_Local_Util::is_customer_registered())
                                                {
                                                    echo '<button class="cd-select mo_license_plan" onclick="showmodal()">'.JText::_('COM_MINIORANGE_SAML_UPGRADE_BTN').'</button>';
                                                }
                                                else
                                                {
                                                    $redirect1= "https://login.xecurify.com/moas/login?username=" . $user_email . "&redirectUrl=https://login.xecurify.com/moas/initializepayment&requestOrigin=joomla_saml_sso_basic_plan";
                                                    echo '<a target="_blank" class="cd-select mo_license_plan"  href="'.$redirect1.'" >'.JText::_('COM_MINIORANGE_SAML_UPGRADE_BTN').'</a>';
                                                }
                                            ?>
                                            </footer><br>
                    
                                            <div class="cd-pricing-body" > 
                                                <?php echo JText::_('COM_MINIORANGE_SAML_BASIC_FEATURES'); ?>   
                                            </div>
                                        </li>
                                    </ul> 
                                </li>
                                <li class="cd-black">
                                    <ul class="cd-pricing-wrapper"  >
                                        <li id="singlesite_tab" data-type="singlesite" class="mosslp is-visible cd-singlesite" >
                                            <header class="cd-pricing-header">
                                                <h2 style="margin-bottom: 10px" >Standard<br/></h2><span class="mo_saml_plan_description"><strong>( <?php echo JText::_('COM_MINIORANGE_SAML_STANDARD'); ?>)</strong></span><br>
                                            
                                            
                                            </header>
                                            <div style="text-align:center;display:none" >
                                                    <span id="plus_total_price" class="plus_total_price">$199*</span><br><span class="mo_saml_note"><strong>[ <?php echo JText::_('COM_MINIORANGE_SAML_ONE_TIME'); ?>]</strong></span> <br/>
                                                </div>
                                            <footer class="cd-pricing-footer" >
                                            <?php
                                                if (!Mo_Saml_Local_Util::is_customer_registered())
                                                {
                                                    echo '<button class="cd-select mo_license_plan" onclick="showmodal()">'.JText::_('COM_MINIORANGE_SAML_UPGRADE_BTN').'</button>';
                                                }
                                                else
                                                {
                                                    $redirect1= "https://login.xecurify.com/moas/login?username=" . $user_email . "&redirectUrl=https://login.xecurify.com/moas/initializepayment&requestOrigin=joomla_saml_sso_standard_plan";
                                                    echo '<a target="_blank" class="cd-select mo_license_plan"  href="'.$redirect1.'" >'.JText::_('COM_MINIORANGE_SAML_UPGRADE_BTN').'</a>';
                                                }
                                            ?>
                                            </footer><br>
                                            <div class="cd-pricing-body"> 
                                                <?php echo JText::_('COM_MINIORANGE_SAML_STANDARD_FEATURES'); ?>
                                            </div>
                                        </li>
                                    </ul> 
                                </li>
                                <li class="cd-black">
                                    <ul class="cd-pricing-wrapper">
                                        <li id="singlesite_tab" data-type="singlesite" class="mosslp is-visible">
                                            <header class="cd-pricing-header">
                                                <h2 style="margin-bottom: 10px">Premium<br/></h2><span class="mo_saml_plan_description"><strong>( <?php echo JText::_('COM_MINIORANGE_SAML_PREMIUM'); ?>)</strong></span><br/>
                                                
                                            </header>
                                            <div style="text-align:center;display:none">
                                                    <span id="plus_total_price" class="plus_total_price" >$349*</span><br><span class="mo_saml_note"><strong>[ <?php echo JText::_('COM_MINIORANGE_SAML_ONE_TIME'); ?>]</strong></span> <br/> 
                                            </div>
                                            <footer class="cd-pricing-footer">
                                                <?php
                                                    if (!Mo_Saml_Local_Util::is_customer_registered())
                                                    {
                                                        echo '<button class="cd-select mo_license_plan" onclick="showmodal()">'. JText::_('COM_MINIORANGE_SAML_UPGRADE_BTN').'</button>';
                                                    }
                                                    else
                                                    {
                                                        $redirect1= "https://login.xecurify.com/moas/login?username=" . $user_email . "&redirectUrl=https://login.xecurify.com/moas/initializepayment&requestOrigin=joomla_saml_sso_premium_plan";
                                                        echo '<a target="_blank" class="cd-select mo_license_plan"  href="'.$redirect1.'" > '.JText::_('COM_MINIORANGE_SAML_UPGRADE_BTN').'</a>';
                                                    }
                                                ?>
                                            </footer><br>
                                            <div class="cd-pricing-body">
                                                <?php echo JText::_('COM_MINIORANGE_SAML_PREMIUM_FEATURES'); ?>
                                            </div> 
                                        </li>
                                    </ul> 
                                </li>
                                <li class="cd-black">
                                    <ul class="cd-pricing-wrapper">
                                        <li id="singlesite_tab" data-type="singlesite" class="mosslp is-visible">
                                            <header class="cd-pricing-header">
                                                <h2 style="margin-bottom:10px;">Enterprise<br/></h2><span class="mo_saml_plan_description"><strong>( <?php echo JText::_('COM_MINIORANGE_SAML_ENTER'); ?>)</strong></span><br/>
                                                
                                            </header>
                                            <div style="text-align:center;display:none" >
                                                    <span id="plus_total_price" class="plus_total_price">$399*</span><br><span class="mo_saml_note"><strong>[ <?php echo JText::_('COM_MINIORANGE_SAML_ONE_TIME'); ?>]</strong></span> <br/>
                                            </div>
                                            <footer class="cd-pricing-footer">
                                            <?php
                                                if (!Mo_Saml_Local_Util::is_customer_registered())
                                                {
                                                    echo '<button class="cd-select mo_license_plan"  onclick="showmodal()">'.JText::_('COM_MINIORANGE_SAML_UPGRADE_BTN').'</button>';
                                                }
                                                else
                                                {
                                                    $redirect1= "https://login.xecurify.com/moas/login?username=" . $user_email . "&redirectUrl=https://login.xecurify.com/moas/initializepayment&requestOrigin=joomla_saml_sso_enterprise_plan";
                                                    echo '<a target="_blank" class="cd-select mo_license_plan"  href="'.$redirect1.'" > '.JText::_('COM_MINIORANGE_SAML_UPGRADE_BTN').'</a>';
                                                }
                                            ?>
                                            </footer><br>
                                            <div class="cd-pricing-body">
                                                <?php echo JText::_('COM_MINIORANGE_SAML_ENTER_FEATURES'); ?>
                                            </div> 
                                        </li>
                                    </ul> 
                                </li>
                                <li class="cd-black">
                                    <ul class="cd-pricing-wrapper" >
                                        <li id="singlesite_tab" data-type="singlesite" class="mosslp is-visible cd-singlesite">
                                            <header class="cd-pricing-header">
                                                <h2 style="margin-bottom: 10px" >All Inclusive</h2><span class="mo_saml_plan_description"><strong>( <?php echo JText::_('COM_MINIORANGE_SAML_INCLUSIVE'); ?>)</strong></span><br>
                                                <select name="user-slab" class="mo_sp_inclusive_plans slab_dropdown">
                                                    <option value="basic" style="text-align:center" selected>Basic</option>
                                                    <option value="pro" style="text-align:center" >Pro</option>    
                                                </select>
                                            </header>
                                            <div style="text-align:center;display:none" >
                                                <span id="plus_total_price_basic" class="plus_total_price" >$499*</span>
                                                <span id="plus_total_price_pro" class="plus_total_price" style="display:none">$599*</span>
                                            </div>
                                            <div style="text-align:center;display:none" >
                                                <span class="mo_saml_note"><strong>[ <?php echo JText::_('COM_MINIORANGE_SAML_ONE_TIME'); ?>]</strong></span>
                                            </div>
                                            <footer class="cd-pricing-footer">
                                            <?php
                                                echo '<a target="_blank" class="cd-select mo_license_plan" href="https://www.miniorange.com/contact" >'.JText::_('COM_MINIORANGE_SAML_CONTACT_US').'</a>';
                                            ?>
                                            </footer><br>
                                            <div class="cd-pricing-body"> 
                                                <?php echo JText::_('COM_MINIORANGE_SAML_INCLUSIVE_FEATURES'); ?>
                                            </div>
                                        </li>
                                    </ul> 
                                </li>
                            </ul>
                        </div> 
                    </div><br>
                </div>  
            </div>  
            <?php echo showAddonsContent();?>
            <div class="mo_licensing_page_div mo_boot_pt-3"  id="upgrade-steps">
                <div>
                    <h2 style="text-align:center"> <?php echo JText::_('COM_MINIORANGE_SAML_UPGRADE_HEADER'); ?></h2>
                </div> <hr>
                <section  id="section-steps" >
                    <div class="mo_boot_col-sm-12 mo_boot_row ">
                        <div class=" mo_boot_col-sm-6 mo_works-step">
                            <div><strong>1</strong></div>
                            <p> <?php echo JText::_('COM_MINIORANGE_SAML_UPGRADE_ONE'); ?></p>
                        </div>
                        <div class="mo_boot_col-sm-6 mo_works-step">
                            <div><strong>4</strong></div>
                            <p> <?php echo JText::_('COM_MINIORANGE_SAML_UPGRADE_FOUR'); ?></p>
                        </div>       
                    </div>
                    <div class="mo_boot_col-sm-12 mo_boot_row ">
                        <div class=" mo_boot_col-sm-6 mo_works-step">
                            <div><strong>2</strong></div>
                            <p> <?php echo JText::_('COM_MINIORANGE_SAML_UPGRADE_TWO'); ?></p>
                        </div>
                        <div class="mo_boot_col-sm-6 mo_works-step">
                            <div><strong>5</strong></div>
                            <p> <?php echo JText::_('COM_MINIORANGE_SAML_UPGRADE_FIVE'); ?></p>
                        </div>     
                    </div>

                    <div class="mo_boot_col-sm-12 mo_boot_row ">
                        <div class="mo_boot_col-sm-6 mo_works-step">
                            <div><strong>3</strong></div>
                            <p> <?php echo JText::_('COM_MINIORANGE_SAML_UPGRADE_THREE'); ?> </p>
                        </div>
                        <div class=" mo_boot_col-sm-6 mo_works-step">
                            <div><strong>6</strong></div>
                            <p> <?php echo JText::_('COM_MINIORANGE_SAML_UPGRADE_SIX'); ?></p>
                        </div>
                        
                    </div> 
                </section>           
            </div>
            <div  id="payment-method" class="mo_licensing_page_div mo_boot_mt-4 mo_boot_pt-4" >
                <h2 style="text-align:center"><?php echo JText::_('COM_MINIORANGE_SAML_PAYMENT_METHODS'); ?></h2><hr>
                <section style="height: 350px;" >
                    <div class="mo_boot_col-sm-12 mo_boot_row">  
                            <div class="mo_boot_col-sm-4">
                                <div class="mo_plan-box">
                                    <div style="background-color:white; border-radius:10px; ">
                                        <em style="font-size:30px;" class="fa fa-cc-amex" aria-hidden="true"></em>
                                        <em style="font-size:30px;" class="fa fa-cc-visa" aria-hidden="true"></em>
                                        <em style="font-size:30px;" class="fa fa-cc-mastercard" aria-hidden="true"></em>
                                    </div>
                                    <div><?php echo JText::_('COM_MINIORANGE_SAML_PAYMENT_ONE'); ?></div>
                                </div>
                            </div>
                            <div class="mo_boot_col-sm-4">
                                <div class="mo_plan-box">
                                    <div style="background-color:white; border-radius:10px; ">
                                        <img class="mo_payment-images"  src="<?php echo JUri::base();?>/components/com_miniorange_saml/assets/images/paypal.png" alt=""  width="140px;">
                                    </div>
                                    <div><?php echo JText::_('COM_MINIORANGE_SAML_PAYMENT_TWO'); ?></div>
                                </div>
                            </div>
                            <div class="mo_boot_col-sm-4">
                                <div class="mo_plan-box">
                                    <div style="background-color:white; border-radius:10px; ">
                                        <img class="mo_payment-images card-image" src="" alt=""> 
                                        <em style="font-size:30px;" class="fa fa-university" aria-hidden="true"><span style="font-size: 20px;font-weight:500;">&nbsp;&nbsp;<?php echo JText::_('COM_MINIORANGE_SAML_PAYMENT_BANK'); ?></span></em>
                                        
                                    </div>
                                    <div> <?php echo JText::_('COM_MINIORANGE_SAML_PAYMENT_THREE'); ?></div>
                                </div>
                            </div>
                        
                    </div>
                    <div class="row">
                        <p style="margin-top:20px;font-size:16px;text-align:center"><?php echo JText::_('COM_MINIORANGE_SAML_PAYMENT_NOTE'); ?></p>
                    </div>
                </section>
            </div>
            <div class="mo_licensing_page_div  mo_boot_mt-4 mo_boot_pt-4">
                <h2 style="text-align:center"><?php echo JText::_('COM_MINIORANGE_SAML_LICENSING_POLICY'); ?></h2><hr>
                <div class="mo_boot_ml-5"><?php echo JText::_('COM_MINIORANGE_SAML_LICENSING_POLICY_DESC'); ?></div>
            </div>
        </div>
    </div>
    <?php
}

function showAddonsContent(){

    define("MO_ADDONS_CONTENT",serialize( array(

        "JOOMLA_ICB" =>      [
            'id' => 'mo_joomla_icb',
            'addonName'  => 'Integrate with Community Builder',
            'addonDescription'  => JText::_('COM_MINIORANGE_SAML_ADDON_ONE'),
            'addonLink' => 'https://www.miniorange.com/contact',
        ],
        "JOOMLA_IP_RESTRICT" =>      [
            'id' => 'mo_joomla_ip_rest',
            'addonName'  => 'Media Restriction',
            'addonDescription'  => JText::_('COM_MINIORANGE_SAML_ADDON_TWO'),
            'addonLink' => 'https://plugins.miniorange.com/media-restriction-in-joomla',
        ],
        "JOOMLA_USER_SYNC_OKTA" =>      [
            'id' => 'mo_joomla_okta_sync',
            'addonName'  => 'Sync users from your IdP in Joomla (SCIM Plugin)',
            'addonDescription'  => JText::_('COM_MINIORANGE_SAML_ADDON_THREE'),
            'addonLink' => 'https://plugins.miniorange.com/joomla-scim-user-provisioning',
        ],
        "JOOMLA_PAGE_RESTRICTION" =>      [
            'id' => 'mo_joomla_page_rest',
            'addonName'  => 'Page Restriction',
            'addonDescription'  => JText::_('COM_MINIORANGE_SAML_ADDON_FOUR'),
            'addonLink' => 'https://plugins.miniorange.com/page-and-article-restriction-for-joomla',
        ],
        "JOOMLA_SSO_AUDIT" =>      [
            'id' => 'mo_joomla_audit',
            'addonName'  => 'SSO Login Audit',
            'addonDescription'  => JText::_('COM_MINIORANGE_SAML_ADDON_FIVE'),
            'addonLink' => 'https://plugins.miniorange.com/joomla-login-audit-login-activity-report',
        ],
        "JOOMLA_RBA" =>      [
            'id' => 'mo_joomla_rba',
            'addonName'  => 'Role/Group Based Redirection',
            'addonDescription'  => JText::_('COM_MINIORANGE_SAML_ADDON_SIX'),
            'addonLink' => 'https://plugins.miniorange.com/role-based-redirection-for-joomla',
        ],
    )));

    $displayMessage = "";
    $messages = unserialize(MO_ADDONS_CONTENT);


    echo '<div class="mo_licensing_page_div mo_boot_p-5 mo_boot_mt-3" id="addonContent"><h2 style="text-align:center">'.JText::_('COM_MINIORANGE_SAML_ADDON_HEADER').'</h2><hr><div class="mo_otp_wrapper">';
    foreach ($messages as $messageKey)
    {
        $message_keys = isset($messageKey['addonName']) ? $messageKey['addonName'] : '';
        $message_description = isset($messageKey["addonDescription"]) ? $messageKey["addonDescription"] : JText::_('COM_MINIORANGE_SAML_ADDON_INTEREST');
        echo'<div id="'.$messageKey["id"].'">
                <h3 style="color:white;text-align:center">'.$message_keys.'<br/><br/></h3>                              
                <footer style="text-align:center">
                    <a type="button" class="mo_btn btn-primary" style="background-color: #007bff" href="'.$messageKey['addonLink'].'" target="_blank">'.JText::_('COM_MINIORANGE_SAML_ADDON_BTN').'</a>  
                </footer>
                <span class="cd-pricing-body">
                    <ul class="cd-pricing-features">
                        <li style="color:white;text-align: center;">'.$message_description.'</li>
                    </ul>
                </span>
            </div>';
    }
    echo '</div></div><br>';
    return $displayMessage;
}

function group_mapping()
{

    $saml_db_values = new Mo_saml_Local_Util();
    $role_mapping = $saml_db_values->_load_db_values('#__miniorange_saml_role_mapping');
    $role_mapping_key_value = array();
    $attribute = $saml_db_values->_load_db_values('#__miniorange_saml_config');

    if ($attribute) {
        $group_attr = $attribute['grp'];
    } else {
        $group_attr = '';
    }

    if (isset($role_mapping['mapping_value_default'])) $mapping_value_default = $role_mapping['mapping_value_default'];
    else $mapping_value_default = "";
    $enable_role_mapping = 0;
    if (isset($role_mapping['enable_saml_role_mapping'])) $enable_role_mapping = $role_mapping['enable_saml_role_mapping'];
    
    $db = JFactory::getDbo();
    $db->setQuery($db->getQuery(true)
        ->select('*')
        ->from("#__usergroups"));
    $groups = $db->loadRowList();

    ?>
    <div class="mo_boot_row  mo_boot_mr-1 mo_boot_p-3 mo_tab_border" >
        <div class="mo_boot_col-sm-6  mo_boot_mt-3">
            <h3><?php echo JText::_('COM_MINIORANGE_SAML_GROUP_MAPPING_TAB'); ?><sup><a href="https://developers.miniorange.com/docs/joomla/saml-sso/saml-group-mapping" target="_blank" class="mo_saml_know_more" title="<?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>"><div class="fa fa-question-circle-o"></div></a></sup></h3>
        </div>
        <div class="mo_boot_col-sm-12  mo_boot_mt-1">
        <hr>
            <form action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.saveRolemapping'); ?>" method="post" name="adminForm" id="group_mapping_form">
                <div class="mo_boot_row mo_boot_mt-1">
                    <div class="mo_boot_col-sm-12 alert alert-info"> 
                        <?php echo JText::_('COM_MINIORANGE_SAML_GROUP_MAPPING_NOTE'); ?>
                    </div>
                </div>
                <div class="mo_boot_row mo_boot_mt-5" id="mo_sp_grp_defaultgrp">
                    
                    <div class="mo_boot_col-sm-8">
                        <p><strong><?php echo JText::_('COM_MINIORANGE_SAML_DEFAULT_GROUP'); ?></strong></p>
                    </div>
                    <div class="mo_boot_col-sm-4">
                        <select class="mo_boot_form-control" name="mapping_value_default" style="width:100%" id="default_group_mapping" >
                            <?php

                                foreach ($groups as $group) {
                                    if ($group[4] != 'Super Users') {
                                        if ($mapping_value_default == $group[0]) echo '<option selected="selected" value = "' . $group[0] . '">' . $group[4] . '</option>';
                                        else echo '<option  value = "' . $group[0] . '">' . $group[4] . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mo_boot_col-sm-12 mo_boot_mt-1 alert alert-info" style="background-color: #eae9e9">
                    <div class="mo_boot_p-2">
                        <input id="mo_sp_grp_enable" class="mo_saml_custom_checkbox" type="checkbox" name="enable_role_mapping" value="1"  <?php if ($enable_role_mapping == 1) echo "checked"; ?> disabled >&emsp;<?php echo JText::_('COM_MINIORANGE_SAML_CHECK_ONE'); ?><sup><strong><a href='#' class='premium' onclick="moSAMLUpgrade();">[Standard</a> <a href='#' class='premium' onclick="moSAMLUpgrade();">, Premium</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise]</a></strong></sup>
                        <p class="mo_saml_custom_checkbox">&emsp;&emsp;<?php echo JText::_('COM_MINIORANGE_SAML_CHECK_ONE_NOTE'); ?></p>
                        <input type="checkbox" class="mo_saml_custom_checkbox" name="disable_update_existing_users_role" value="1" disabled>&emsp;<?php echo JText::_('COM_MINIORANGE_SAML_CHECK_TWO'); ?><sup> <strong> <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>[Premium</strong></a>, <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Enterprise]</strong></a></strong></sup><br>
                        <input type="checkbox" class="mo_saml_custom_checkbox" name="disable_update_existing_users_role" value="1"  disabled>&emsp;<?php echo JText::_('COM_MINIORANGE_SAML_CHECK_THREE'); ?><sup><strong> <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>[Premium</strong></a>, <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Enterprise]</strong></a></strong></sup><br>
                        <input type="checkbox" class="mo_saml_custom_checkbox" name="disable_create_users" value="1"  disabled>&emsp;<?php echo JText::_('COM_MINIORANGE_SAML_CHECK_FOUR'); ?> <sup><strong> <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>[Premium</strong></a>, <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Enterprise]</strong></a></strong></sup><br>
                    </div>
                </div>
            </form>
        </div>
        <div class="mo_boot_col-sm-12 mo_boot_table-responsive mo_boot_mt-3">
            <div class="mo_boot_row">
                <div class="mo_boot_col-4">
                    <h4 class="mo_boot_ml-5"><?php echo JText::_('COM_MINIORANGE_SAML_GROUP'); ?></h4>
                </div>
                <div class="mo_boot_col-8">
                    <input disabled class="mo_saml_table_textbox mo_boot_form-control" type="text" name="grp" value="<?php echo $group_attr; ?>" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_GROUP_ATTRIBUTE_NAME'); ?>"/>
                    <?php echo JText::_('COM_MINIORANGE_SAML_GROUP_NOTE'); ?>
                </div>
            </div>
            <div class="mo_boot_row mo_boot_mt-4" style="color: #d9534f;">
                <div class="mo_boot_col-4 mo_boot_text-center">
                    <strong><?php echo JText::_('COM_MINIORANGE_SAML_GROUP_MAP_HEADER1'); ?></strong>
                </div>
                <div class="mo_boot_col-8 mo_boot_text-center">
                    <strong><?php echo JText::_('COM_MINIORANGE_SAML_GROUP_MAP_HEADRER2'); ?></strong>
                </div>
            </div>
            
            <?php
                if (empty($role_mapping_key_value)) {
                    foreach ($groups as $group) {
                        if ($group[4] != 'Super Users') {
                            ?>
                            <div class="mo_boot_row mo_boot_mt-2">
                                <div class="mo_boot_col-4">
                                    <span><h5 class="mo_boot_ml-5"><?php echo $group[4]; ?></h5></span>
                                </div>
                                <div class="mo_boot_col-8">
                                    <input type="text" name="saml_am_group_attr_values_<?php echo $group[0] ?>" value= "" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_GROUP_MAPPING_PLACEHOLDER'); ?><?php echo  $group[4] ?>"  disabled class="mo_boot_form-control" />
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
            ?>
            <div class="mo_boot_col-sm-12 mo_boot_mt-3 mo_boot_text-center">
                <input id="mo_sp_grp_save" type="submit" class="mo_boot_btn  mo_boot_btn-success" value="<?php echo JText::_('COM_MINIORANGE_SAML_SAVE_BTN'); ?>" disabled/>
            </div>
        </div>   
    </div>
    <?php

}


function mo_sso_login()
{

    $siteUrl = JURI::root();
    $sp_base_url = $siteUrl;
    $button_style="{
        border: 1px solid rgba(0, 0, 0, 0.2);
        color: #fff;
        background-color: #226a8b !important;
        padding: 4px 12px;
        border-radius: 3px;
    }";
    ?>
    <div class="mo_boot_row  mo_boot_mx-1 mo_boot_p-3 mo_tab_border" >
        <div class="mo_boot_col-sm-12 mo_boot_mt-3">
            <div class="mo_boot_row">
                <div class="mo_boot_col-lg-9 mo_boot_mt-1">
                    <h3> <?php echo JText::_('COM_MINIORANGE_SAML_LOGIN_SETTING_TAB'); ?><sup><a href='https://developers.miniorange.com/docs/joomla/saml-sso/saml-redirection-and-sso-links' target='_blank' class="mo_saml_know_more" title=" <?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>"><div class="fa fa-question-circle-o"></div></a></sup></h3>
                </div>
            </div><hr>
        </div>
        <div class="mo_boot_col-sm-12 mo_boot_mt-3 ">
            <div class="mo_saml_sso_url_style" >
                <div class="mo_boot_row ">
                    <div class="mo_boot_col-lg-2 ">
                        <strong> <?php echo JText::_('COM_MINIORANGE_SAML_SSO_URL'); ?><div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext" > <?php echo JText::_('COM_MINIORANGE_SAML_SSO_URL_TIP'); ?></span></div> : </strong>
                    </div>
                    <div class="mo_boot_col-lg-8 ">
                        <span id="sso_url" style="color:#2a69b8" >
                            <strong><?php echo  $sp_base_url . '?morequest=sso'; ?></strong>
                        </span>
                    </div>
                    <div class="mo_boot_col-lg-2 ">
                        <em class="fa fa-lg fa-copy mo_copy mo_copytooltip" onclick="copyToClipboard('#sso_url');" ><span class="mo_copytooltiptext copied_text"> <?php echo JText::_('COM_MINIORANGE_SAML_COPY_BTN'); ?></span>  </em>
                    </div>
                </div>
            </div>
        </div>
        <div class="mo_boot_col-sm-12 mo_boot_mt-4">
                <details>
                    <summary class="mo_saml_summary"> <?php echo JText::_('COM_MINIORANGE_SAML_SSO_LINK'); ?></summary><hr>
                    <ul> 
                        <?php echo JText::_('COM_MINIORANGE_SAML_SSO_LINK_STEPS'); ?>
                    </ul>
                </details>
        </div>

        <div class="mo_boot_col-sm-12">
            <details>
                <summary class="mo_saml_summary"> <?php echo JText::_('COM_MINIORANGE_SAML_SSO_BTN'); ?><sup>[<strong><a href='#' class='premium' onclick="moSAMLUpgrade();">Standard</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Premium</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise</a></strong>]</sup></summary><hr>
                <textarea disabled="disabled" rows="5" cols="100" class="mo_saml_table_textbox mo_boot_w-100" placeholder="<?php echo $button_style ?>"></textarea>
            </ul>
            </details>
            <hr/>
        </div>
        <div class="mo_boot_col-sm-12 mo_boot_mt-4 mo_boot_text-center">
            <h2 style="color: #d9534f;"> <?php echo JText::_('COM_MINIORANGE_SAML_LICENSE_VERSION_FEATURES'); ?></h2>
        </div>
        <div class="mo_boot_col-sm-12 mo_saml_sso_link_style">
            <p>
                <h4>
                    <input type="checkbox" class="mo_saml_checkbox" disabled> <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_ONE'); ?>
                    <sup>[<strong><a href='#' class='premium' onclick="moSAMLUpgrade();">Standard</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Premium</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise</a></strong>]</sup>
                </h4>    
            </p>
            <p class='alert alert-info' > <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_ONE_NOTE'); ?></p><br>

            <p>
                <h4><input type="checkbox" class="mo_saml_checkbox" disabled> <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_TWO'); ?><sup>[<strong><a href='#' class='premium' onclick="moSAMLUpgrade();">Standard</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Premium</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise</a></strong>]</sup></h4>     
            </p>
            <p class='alert alert-info'> <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_TWO_NOTE'); ?></p><br>

            <p><h4><input type="checkbox" class="mo_saml_checkbox" disabled> <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_THREE'); ?> "<?php echo $siteUrl."administrator"?>" URL
                    <sup>[<strong><a href='#' class='premium' onclick="moSAMLUpgrade();">Premium</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise</a></strong>]</sup><br><br>
                    <input type="checkbox" class="mo_saml_checkbox" disabled> <?php echo JText::_('COM_MINIORANGE_SAML_BACKDOOR'); ?>
                    <sup>[<strong><a href='#' class='premium' onclick="moSAMLUpgrade();">Premium</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise</a></strong>]</sup>
                </h4>
            </p>
            <p class='alert alert-info'> <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_THREE_NOTE'); ?></p><br>

            <p>
                <h4>
                    <input type="checkbox" class="mo_saml_checkbox" disabled> <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_FOUR'); ?>
                    <sup>[<strong><a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise </a></strong>]</sup>
                </h4>
            </p>
            <p class='alert alert-info'>
                <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_FOUR_NOTE'); ?>
            </p><br>

            <p>
                <h4>
                    <input type="checkbox" class="mo_saml_checkbox" disabled> <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_FIVE'); ?>
                    <sup>[<strong><a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise </a></strong>]</sup>
                </h4>
            </p>
            <p class='alert alert-info'>
                <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_FIVE_NOTE'); ?>
            </p><br>

            <p>
                <h4>
                    <input type="checkbox" class="mo_saml_checkbox" disabled> <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_SIX'); ?>
                        <sup>[<strong><a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise </a></strong>]</sup>
                </h4>
            </p>
            <p class='alert alert-info'>
                <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_SIX_NOTE'); ?>
            </p><br>

            <p>
                <h4>
                    <input type="checkbox" class="mo_saml_checkbox" disabled> <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_SEVEN'); ?>
                    <sup>[<strong><a href='#' class='premium' onclick="moSAMLUpgrade();">Standard</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Premium</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise</a></strong>]</sup>
                </h4>
            </p>
            <p class='alert alert-info'>
                <?php echo JText::_('COM_MINIORANGE_SAML_SSO_FEATURE_SEVEN_NOTE'); ?>
            </p>
        </div>
    </div>
    <?php
}

function attribute_mapping()
{
    ?>
    <div class="mo_boot_row  mo_boot_mx-1 mo_boot_p-3 mo_tab_border">
        <div class="mo_boot_col-sm-12 mo_boot_mt-3">
            <div class="mo_boot_row">
                <div class="mo_boot_col-lg-9 mo_boot_mt-1">
                    <h3> <?php echo JText::_('COM_MINIORANGE_SAML_ATTRIBUTE_MAPPING_TAB'); ?><sup><a href='https://developers.miniorange.com/docs/joomla/saml-sso/saml-attribute-mapping' target='_blank' class="mo_saml_know_more" title=" <?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>"><div class="fa fa-question-circle-o"></div></a></sup></h3>
                </div>
            </div> <hr> 
        </div>
        <div class="mo_boot_col-sm-12 mo_boot_mt-2">
            <form action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.saveConfig'); ?>" method="post" name="adminForm" id="attribute_mapping_form">
                <div class="mo_boot_row mo_boot_mt-1">
                    <div class="mo_boot_col-sm-12">
                        <input type="checkbox" value="1" disabled class="mo_saml_custom_checkbox">&emsp;<strong> <?php echo JText::_('COM_MINIORANGE_SAML_ATTRIBUTE_MAPPING_CHECKBOX'); ?></strong> <sup><strong> <a href='#' class='premium' onclick="moSAMLUpgrade();">[Premium</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise]</a></strong></sup>
                        <p class='alert alert-info mo_boot_mt-3' style="color:#151515;"> <?php echo JText::_('COM_MINIORANGE_SAML_ATTRIBUTE_MAPPING_NOTE'); ?></p>
                    </div>   
                </div>
                <div class="mo_boot_col-sm-12">
                    <strong> <?php echo JText::_('COM_MINIORANGE_SAML_BASIC_ATTRIBUTE_MAPPING'); ?></strong> <sup><strong><a href='#' class='premium' onclick="moSAMLUpgrade();">[Standard</a> <a href='#' class='premium' onclick="moSAMLUpgrade();">, Premium</a>, <a href='#' class='premium' onclick="moSAMLUpgrade();">Enterprise]</a></strong></sup>
                    <div class="mo_boot_row mo_boot_mt-3"  id="mo_saml_uname" >
                        <div class="mo_boot_col-sm-3">
                            <strong> <?php echo JText::_('COM_MINIORANGE_SAML_ATTRIBUTE_USERNAME'); ?></strong>
                        </div>
                        <div class="mo_boot_col-sm-8">
                            <input disabled class="mo_saml_table_textbox mo_boot_form-control" type="text" name="username"required placeholder="NameID" value="NameID" />
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_mt-1"  id="mo_saml_email">
                        <div class="mo_boot_col-sm-3">
                            <strong> <?php echo JText::_('COM_MINIORANGE_SAML_ATTRIBUTE_EMAIL'); ?></strong>
                        </div>
                        <div class="mo_boot_col-sm-8">
                            <input disabled class="mo_saml_table_textbox mo_boot_form-control" type="text" name="email"required placeholder="NameID" value="NameID" />
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_mt-1" id="mo_sp_attr_name">
                        <div class="mo_boot_col-sm-3">
                            <strong> <?php echo JText::_('COM_MINIORANGE_SAML_ATTRIBUTE_NAME'); ?></strong>
                        </div>
                        <div class="mo_boot_col-sm-8">
                            <input  disabled class="mo_saml_table_textbox mo_boot_form-control" type="text" name="name"  placeholder=" <?php echo JText::_('COM_MINIORANGE_SAML_ATTRIBUTE_NAME_MAPPING'); ?>" />
                        </div>
                    </div>
                    <div class="mo_boot_row  mo_boot_mt-4 mo_boot_text-center" id="mo_sp_attr_save_attr">
                        <div class="mo_boot_col-sm-12">
                            <input disabled type="submit" class="mo_boot_btn mo_boot_btn-success" value=" <?php echo JText::_('COM_MINIORANGE_SAML_ATTRIBUTE_MAPPING_BTN'); ?>"/>
                        </div>
                    </div>
                </div>
            
            </form>
        </div>
        <div class="mo_boot_col-sm-12 mo_boot_mt-5">
            <strong> 
                <?php echo JText::_('COM_MINIORANGE_SAML_PROFILE_ATTRIBUTE_MAPPING'); ?>
                <sup>
                    <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>[Premium</strong></a>, <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Enterprise]</strong></a>
                </sup>
                <input type="button" class="mo_boot_btn mo_boot_btn-primary" disabled value="+" />
                <input type="button" class="mo_boot_btn mo_boot_btn-danger" disabled value="-" />
            </strong>
            <hr>
            <a id="attribute_profile_mapping_info" href="#info1" > <?php echo JText::_('COM_MINIORANGE_SAML_CLICK_KNOW_MORE'); ?></a>
            <div id='profile_mapping_info' style="display:none">
                <p class="alert alert-info"> <?php echo JText::_('COM_MINIORANGE_SAML_PROFILE_ATTRIBUTE_NOTE1'); ?></p>
            </div>
            
            <p class="alert alert-info "> <?php echo JText::_('COM_MINIORANGE_SAML_PROFILE_ATTRIBUTE_NOTE2'); ?></p>
        </div>
        <div class="mo_boot_col-sm-6 mo_boot_mt-1">
            <div class="mo_boot_row mo_boot_mt-1">
                <div class="mo_boot_col-sm-12">
                    <strong> <?php echo JText::_('COM_MINIORANGE_SAML_PROFILE_ATTRIBUTE_HEADER'); ?></strong>
                </div>
                <div class="mo_boot_col-sm-12">
                    <input type="text" class="mo_boot_form-control" disabled="disabled"/>
                </div>
            </div>
        </div>
        <div class="mo_boot_col-sm-6 mo_boot_mt-1">
            <div class="mo_boot_row mo_boot_mt-1">
                <div class="mo_boot_col-sm-12">
                    <strong> <?php echo JText::_('COM_MINIORANGE_SAML_IDP_ATTRIBUTE'); ?></strong>
                </div>
                <div class="mo_boot_col-sm-12">
                    <input type="text" class="mo_boot_form-control" disabled="disabled"/>
                </div>
            </div>
        </div>
        <div class="mo_boot_col-sm-12 mo_boot_mt-5">
            <strong> 
                <?php echo JText::_('COM_MINIORANGE_SAML_FIELD_ATTRIBUTE_MAPPING'); ?>
                <sup>
                    <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>[Enterprise]</strong></a>
                </sup>
                <input type="button" class="mo_boot_btn mo_boot_btn-primary" disabled value="+" />
                <input type="button" class="mo_boot_btn mo_boot_btn-danger" disabled value="-" />
            </strong>
            <hr>
            <a id="attribute_field_mapping_info" href="#info1" > <?php echo JText::_('COM_MINIORANGE_SAML_CLICK_KNOW_MORE'); ?></a>
            <div id='field_mapping_info' style="display:none">
                <p class="alert alert-info"> <?php echo JText::_('COM_MINIORANGE_SAML_FIELD_ATTRIBUTE_NOTE1'); ?></p>
            </div>
            <p class="alert alert-info"> <?php echo JText::_('COM_MINIORANGE_SAML_FIELD_ATTRIBUTE_NOTE2'); ?></p>
        </div>
        <div class="mo_boot_col-sm-6 mo_boot_mt-1">
            <div class="mo_boot_row mo_boot_mt-1">
                <div class="mo_boot_col-sm-12">
                    <strong> <?php echo JText::_('COM_MINIORANGE_SAML_FIELD_ATTRIBUTE_HEADER'); ?></strong>
                </div>
                <div class="mo_boot_col-sm-12">
                    <input type="text" class="mo_boot_form-control" disabled="disabled"/>
                </div>
            </div>
        </div>
        <div class="mo_boot_col-sm-6 mo_boot_mt-1">
            <div class="mo_boot_row mo_boot_mt-1">
                <div class="mo_boot_col-sm-12">
                    <strong> <?php echo JText::_('COM_MINIORANGE_SAML_IDP_ATTRIBUTE'); ?></strong>
                </div>
                <div class="mo_boot_col-sm-12">
                    <input type="text" class="mo_boot_form-control" disabled="disabled"/>
                </div>
            </div>
        </div>
        <div class="mo_boot_col-sm-12 mo_boot_mt-5">
            <strong> 
                <?php echo JText::_('COM_MINIORANGE_SAML_CONTACT_ATTRIBUTE_MAPPING'); ?>
                <sup>
                    <a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>[Enterprise]</strong></a>
                </sup>
                <input type="button" class="mo_boot_btn mo_boot_btn-primary" disabled value="+" />
                <input type="button" class="mo_boot_btn mo_boot_btn-danger" disabled value="-" />
            </strong>
            <hr>
            <a id="attribute_contact_mapping_info" href="#info1" > <?php echo JText::_('COM_MINIORANGE_SAML_CLICK_KNOW_MORE'); ?></a>
            <div id='contact_map_info' style="display:none">
                <p class="alert alert-info"><?php echo JText::_('COM_MINIORANGE_SAML_CONTACT_ATTRIBUTE_NOTE1'); ?></p>
            </div>
            <p class="alert alert-info"> <?php echo JText::_('COM_MINIORANGE_SAML_CONTACT_ATTRIBUTE_NOTE2'); ?></p>
        </div>
        <div class="mo_boot_col-sm-6 mo_boot_mt-1">
            <div class="mo_boot_row mo_boot_mt-1">
                <div class="mo_boot_col-sm-12">
                    <strong> <?php echo JText::_('COM_MINIORANGE_SAML_CONTACT_ATTRIBUTE_HEADER'); ?></strong>
                </div>
                <div class="mo_boot_col-sm-12">
                    <input type="text" class="mo_boot_form-control" disabled="disabled"/>
                </div>
            </div>
        </div>
        <div class="mo_boot_col-sm-6 mo_boot_mt-1">
            <div class="mo_boot_row mo_boot_mt-1">
                <div class="mo_boot_col-sm-12">
                    <strong> <?php echo JText::_('COM_MINIORANGE_SAML_IDP_ATTRIBUTE'); ?></strong>
                </div>
                <div class="mo_boot_col-sm-12">
                    <input type="text" class="mo_boot_form-control" disabled="disabled"/>
                </div>
            </div>
        </div>
        <div class="mo_boot_col-sm-12 mo_boot_text-center  mo_boot_mt-4">
            <input type="submit" class="mo_boot_btn mo_boot_btn-success" value=" <?php echo JText::_('COM_MINIORANGE_SAML_ATTRIBUTE_MAPPING_BTN'); ?>" disabled/>
        </div>
    </div>
    <?php
}

function proxy_setup()
{
    $proxy = (new Mo_saml_Local_Util)->_load_db_values('#__miniorange_saml_proxy_setup');
    $proxy_host_name = isset($proxy['proxy_host_name']) ? $proxy['proxy_host_name'] : '';
    $port_number = isset($proxy['port_number']) ? $proxy['port_number'] : '';
    $username = isset($proxy['username']) ? $proxy['username'] : '';
    $password = isset($proxy['password']) ? base64_decode($proxy['password']) : '';
    ?>
    <div class="mo_boot_row mo_boot_p-3"> 
        <div class="mo_boot_col-sm-12"  id="mo_sp_proxy_config">
            <div class="mo_boot_row mo_boot_mt-2">
                <div class="mo_boot_col-sm-9">
                    <input type="hidden" name="option1" value="mo_saml_save_proxy_setting" />
                    <h3><?php echo JText::_('COM_MINIORANGE_SAML_PROXY_SERVER'); ?></h3>
                </div>
                <div class="mo_boot_col-sm-3">
                    <input type="button" class="mo_boot_float-right mo_boot_btn mo_boot_btn-danger" value="<?php echo JText::_('COM_MINIORANGE_SAML_CANCEL'); ?>" onclick = "hide_proxy_form();"/>
                </div>
            </div>
            <hr>
            <form  action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.proxyConfig'); ?>" name="proxy_form" method="post">
                <div class="mo_boot_row">
                    <div class="mo_boot_col-sm-12">  
                        <p><strong><?php echo JText::_('COM_MINIORANGE_SAML_PROXY_SERVER_NOTE'); ?></strong></p>
                        <p><?php echo JText::_('COM_MINIORANGE_SAML_PROXY_SERVER_STEPS'); ?></p>
                    </div>
                </div>
                <div class="mo_boot_row" id="mo_sp_proxy_host_name">
                    <div class="mo_boot_col-sm-3">
                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_PROXY_HOST_NAME'); ?><span class="mo_saml_required">*</span> :</strong>
                    </div>
                    <div class="mo_boot_col-sm-8">
                        <input type="text" name="mo_proxy_host" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_HOST_PLACEHOLDER'); ?>" class="mo_saml_proxy_setup mo_boot_form-control" value="<?php echo $proxy_host_name ?>" required/>
                    </div>
                </div>
                <div class="mo_boot_row" id="mo_sp_port_number">
                    <div class="mo_boot_col-sm-3"><br>
                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_PORT_NUMBER'); ?><span class="mo_saml_required">*</span> :</strong>
                    </div>
                    <div class="mo_boot_col-sm-8"><br>
                        <input type="number" name="mo_proxy_port" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_PORT_NUMBER_PLACEHOLDER'); ?>" class="mo_boot_form-control mo_saml_proxy_setup" value="<?php echo $port_number ?>" required/>
                    </div>
                </div>
                <div class="mo_boot_row" id="mo_sp_proxy_username">
                    <div class="mo_boot_col-sm-3"><br>
                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_ATTRIBUTE_USERNAME'); ?> :</strong>
                    </div>
                    <div class="mo_boot_col-sm-8"><br>
                        <input type="text" name="mo_proxy_username" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_PROXY_USERNAME'); ?>" class="mo_boot_form-control mo_saml_proxy_setup" value="<?php echo $username ?>" />
                    </div>
                </div>
                <div class="mo_boot_row" id="mo_sp_proxy_password">
                    <div class="mo_boot_col-sm-3"><br>
                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_PASSWORD'); ?> :</strong>
                    </div>
                    <div class="mo_boot_col-sm-8"><br>
                        <input type="password" name="mo_proxy_password" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_PROXY_PASSWORD'); ?>" class="mo_boot_form-control mo_saml_proxy_setup" value="<?php echo $password ?>">
                    </div>
                </div>
                <div class="mo_boot_row mo_boot_text-center mo_boot_mt-3">
                    <div class="mo_boot_col-sm-12">
                        <input type="submit" value="<?php echo JText::_('COM_MINIORANGE_SAML_SAVE_BTN'); ?>" class="mo_boot_btn mo_boot_btn-success" />
                    </div>
                </div>
            </form>
            <div class="mo_boot_col-sm-12  mo_boot_text-center  mo_boot_mt-3">
                <form action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.proxyConfigReset'); ?>" name="proxy_form1" method="post">
                    <input type="button" value="<?php echo JText::_('COM_MINIORANGE_SAML_PROXY_RESET_BTN'); ?>" onclick='submit();' class="mo_boot_btn mo_boot_btn-success" />
                </form>
            </div>
        </div>
    </div>
    <?php
}

function customcertificate(){
    ?>
    <form action="" name="customCertificateForm" id="custom_certificate_form">
        
        <div class="mo_boot_row  mo_boot_mx-1 mo_boot_p-3 mo_tab_border" id="generate_certificate_form"   style="display:none">
                <div class="mo_boot_col-sm-12">
                    <div class="mo_boot_row  mo_boot_mt-2">
                        <div class="mo_boot_col-sm-10">
                            <h3> <?php echo JText::_('COM_MINIORANGE_SAML_CUSTOM_CERTIFICATE_TAB'); ?></h3>
                        </div>
                        <div class="mo_boot_col-sm-2">
                            <input type="button" class="mo_boot_btn mo_boot_btn-success" value=" <?php echo JText::_('COM_MINIORANGE_SAML_BACK'); ?>" onclick = "hide_gen_cert_form()"/>
                        </div>
                    </div>
                    <hr> 
                    <div class="mo_boot_row mo_boot_mt-2">
                        <div class="mo_boot_col-sm-3">
                            <strong> <?php echo JText::_('COM_MINIORANGE_SAML_COUNTRY_CODE'); ?><span class="mo_saml_required">*</span> :</strong>
                        </div>
                        <div class="mo_boot_col-sm-7">
                            <input class="mo_saml_table_textbox  mo_boot_form-control" type="text"  placeholder=" <?php echo JText::_('COM_MINIORANGE_SAML_COUNTRY_CODE_PLACEHOLDER'); ?>" disabled>
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_mt-2">
                        <div class="mo_boot_col-sm-3">
                            <strong> <?php echo JText::_('COM_MINIORANGE_SAML_STATE'); ?><span class="mo_saml_required">*</span> :</strong>
                        </div>
                        <div class="mo_boot_col-sm-7">
                            <input class="mo_saml_table_textbox mo_boot_form-control" type="text"  placeholder=" <?php echo JText::_('COM_MINIORANGE_SAML_STATE_PLACEHOLDER'); ?>" disabled />
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_mt-2">
                        <div class="mo_boot_col-sm-3">
                            <strong> <?php echo JText::_('COM_MINIORANGE_SAML_COMPANY'); ?><span class="mo_saml_required">*</span> :</strong>
                        </div>
                        <div class="mo_boot_col-sm-7">
                            <input  class="mo_saml_table_textbox mo_boot_form-control" type="text"  placeholder=" <?php echo JText::_('COM_MINIORANGE_SAML_COMPANY_PLACEHOLDER'); ?>" disabled />
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_mt-2">
                        <div class="mo_boot_col-sm-3">
                            <strong> <?php echo JText::_('COM_MINIORANGE_SAML_UNIT'); ?><span class="mo_saml_required">*</span> :</strong>
                        </div>
                        <div class="mo_boot_col-sm-7">
                            <input  class="mo_saml_table_textbox mo_boot_form-control" type="text" placeholder=" <?php echo JText::_('COM_MINIORANGE_SAML_UNIT_PLACEHOLDER'); ?>" disabled />
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_mt-2">
                        <div class="mo_boot_col-sm-3">
                            <strong> <?php echo JText::_('COM_MINIORANGE_SAML_COMMON'); ?><span class="mo_saml_required">*</span> :</strong>
                        </div>
                        <div class="mo_boot_col-sm-7">
                            <input  class="mo_saml_table_textbox mo_boot_form-control" type="text" placeholder=" <?php echo JText::_('COM_MINIORANGE_SAML_COMMON_PLACEHOLDER'); ?>" disabled />
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_mt-2">
                        <div class="mo_boot_col-sm-3">
                            <strong> <?php echo JText::_('COM_MINIORANGE_SAML_DIGEST_ALGORITH'); ?><span class="mo_saml_required">*</span> :</strong>
                        </div>
                        <div class="mo_boot_col-sm-7">
                            <select class="mo_saml_table_textbox mo_boot_form-control">  <?php echo JText::_('COM_MINIORANGE_SAML_VALID_DAYS'); ?>                             
                                <option>SHA512</option>
                                <option>SHA384</option>
                                <option>SHA256</option>
                                <option>SHA1</option>                            
                            </select>
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_mt-2">
                        <div class="mo_boot_col-sm-3">
                            <strong> <?php echo JText::_('COM_MINIORANGE_SAML_PRIVATE_KEY'); ?><span class="mo_saml_required">*</span> :</strong>
                        </div>
                        <div class="mo_boot_col-sm-7">
                            <select class="mo_saml_table_textbox mo_boot_form-control">  <?php echo JText::_('COM_MINIORANGE_SAML_VALID_DAYS'); ?>                             
                                <option>2048 bits</option>
                                <option>1024 bits</option>                                                               
                            </select>
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_mt-2">
                        <div class="mo_boot_col-sm-3">
                            <strong> <?php echo JText::_('COM_MINIORANGE_SAML_VALID_DAYS'); ?><span class="mo_saml_required">*</span> :</strong>
                        </div>
                        <div class="mo_boot_col-sm-7">
                            <select class="mo_saml_table_textbox mo_boot_form-control">                               
                                <option>365 <?php echo JText::_('COM_MINIORANGE_SAML_DAYS'); ?></option>                                                                                               
                                <option>180 <?php echo JText::_('COM_MINIORANGE_SAML_DAYS'); ?></option>                                                                                               
                                <option>90 <?php echo JText::_('COM_MINIORANGE_SAML_DAYS'); ?></option>                                                                                               
                                <option>45 <?php echo JText::_('COM_MINIORANGE_SAML_DAYS'); ?></option>                                                                                               
                                <option>30 <?php echo JText::_('COM_MINIORANGE_SAML_DAYS'); ?></option>                                                                                               
                                <option>15 <?php echo JText::_('COM_MINIORANGE_SAML_DAYS'); ?></option>                                                                                               
                                <option>7 <?php echo JText::_('COM_MINIORANGE_SAML_DAYS'); ?></option>                                                                                               
                            </select>
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_text-center mo_boot_mt-2">
                        <div class="mo_boot_col-sm-12">
                        <input type="submit" value=" <?php echo JText::_('COM_MINIORANGE_SAML_SELF_SIGNED'); ?>" disabled class="mo_boot_btn mo_boot_btn-success"; />
                        </div>
                    </div>
                </div>
        </div>
        <div class="mo_boot_row  mo_boot_mx-1 mo_boot_p-3 mo_tab_border" id="mo_gen_cert" >
                <div class="mo_boot_col-sm-12">
                    <input id="miniorange_saml_custom_certificate" type="hidden" name="cust_certificate_option" value="miniorange_saml_save_custom_certificate"/>
                    <h3> <?php echo JText::_('COM_MINIORANGE_SAML_CUSTOM_CERTIFICATE_TAB'); ?> <sup><a href='https://developers.miniorange.com/docs/joomla/saml-sso/saml-custom-certificate' target='_blank' class="mo_saml_know_more" title=" <?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>"><div class="fa fa-question-circle-o"></div></a></sup></h3>
                    <hr>
                </div>
                <div class="mo_boot_col-sm-12 alert alert-info" >
                    <?php echo JText::_('COM_MINIORANGE_SAML_CUSTOM_CRT_NOTE'); ?> 
                </div>
                <div class="mo_boot_col-sm-12 mo_boot_mt-3" id="customCertificateData"><br>
                    <div class="mo_boot_row custom_certificate_table"  >
                        <div class="mo_boot_col-sm-3">
                            <strong>
                                <?php echo JText::_('COM_MINIORANGE_SAML_PUBLIC_CRT'); ?>
                                <span class="mo_saml_required">*</span>
                                <a href='#' class='premium' onclick="moSAMLUpgrade();">[Enterprise]</a>
                            </strong>
                        </div>
                        <div class="mo_boot_col-sm-8">
                            <textarea disabled="disabled" rows="5" cols="100" class="mo_saml_table_textbox mo_boot_w-100"></textarea>
                        </div>
                    </div>
                    <div class="mo_boot_row custom_certificate_table"  >
                        <div class="mo_boot_col-sm-3">
                            <strong>
                                <?php echo JText::_('COM_MINIORANGE_SAML_PRIVATE_CRT'); ?>
                                <span class="mo_saml_required">*</span>
                                <a href='#' class='premium' onclick="moSAMLUpgrade();">[Enterprise]</a>
                            </strong>
                        </div>
                        <div class="mo_boot_col-sm-8">
                            <textarea disabled="disabled" rows="5" cols="100" class="mo_saml_table_textbox mo_boot_w-100"></textarea>
                        </div>
                    </div>
                    <div class="mo_boot_row mo_boot_mt-3 custom_certificate_table"  id="save_config_element">
                        <div class="mo_boot_col-sm-12 mo_boot_text-center">
                            <input disabled="disabled" type="submit" name="submit" value=" <?php echo JText::_('COM_MINIORANGE_SAML_UPLOAD'); ?>" class="mo_boot_btn mo_boot_btn-success"/> &nbsp;&nbsp;
                            <input type="button" name="submit" value=" <?php echo JText::_('COM_MINIORANGE_SAML_GENERATE'); ?>" class="mo_boot_btn  mo_boot_btn-success" onclick="show_gen_cert_form()"/>&nbsp;&nbsp;
                            <input disabled type="submit" name="submit" value=" <?php echo JText::_('COM_MINIORANGE_SAML_RM'); ?>" class="mo_boot_btn  mo_boot_btn-saml"/>
                        </div>
                    </div>
                </div>
        </div>
    </form>
    <?php
}


function requestfordemo()
{
    $current_user = JFactory::getUser();
    $result = new Mo_saml_Local_Util();
    $result = $result->_load_db_values('#__miniorange_saml_customer_details');
    $admin_email = isset($result['email']) ? $result['email'] : '';
    if ($admin_email == '') $admin_email = $current_user->email;
    ?>
    <div class="mo_boot_px-3">
    <div class="mo_boot_row mo_boot_p-3 mo_tab_border">
        <div class="mo_boot_col-sm-12 mo_boot_text-center">
            <h3><?php echo JText::_('COM_MINIORANGE_SAML_TRIAL_TAB'); ?></h3><hr>
        </div>
        <div class="mo_boot_col-sm-12 alert alert-info">
            <p> <?php echo JText::_('COM_MINIORANGE_SAML_TRIAL_DESC'); ?></p>
            <?php echo JText::_('COM_MINIORANGE_SAML_TRIAL_NOTE'); ?>
        </div>
        <div class="mo_boot_col-sm-12 mo_boot_mt-3">
            <form  name="demo_request" method="post" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.requestForTrialPlan');?>">
                <div class="mo_boot_row mo_boot_mt-1">
                    <div class="mo_boot_col-sm-4">
                        <p><span class="mo_saml_required">*</span><strong> <?php echo JText::_('COM_MINIORANGE_SAML_EMAIL'); ?>: </strong></p>
                    </div>
                    <div class="mo_boot_col-sm-8">
                        <input  type="email" class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" name="email" value="<?php echo $admin_email; ?>" placeholder="person@example.com" required />
                    </div>
                    <div class="mo_boot_col-sm-12 mo_boot_mt-1">
                        <div class="mo_boot_row">
                            <div class="mo_boot_col-sm-4">
                                <p><span class="mo_saml_required">*</span><strong> <?php echo JText::_('COM_MINIORANGE_SAML_REQUEST_TRIAL'); ?>:</strong></p>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <select required class="mo_boot_form-control mo_saml_proxy_setup"  name="plan">
                                    <option disabled selected style="text-align: center">----------------------- <?php echo JText::_('COM_MINIORANGE_SAML_SELECT'); ?> -----------------------</option>
                                    <option value="Joomla SAML Standard Plugin">Joomla SAML SP Standard Plugin</option>
                                    <option value="Joomla SAML Premium Plugin">Joomla SAML SP Premium Plugin</option>
                                    <option value="Joomla SAML Enterprise Plugin">Joomla SAML SP Enterprise Plugin</option>
                                    <option value="Not Sure"> <?php echo JText::_('COM_MINIORANGE_SAML_NOT_SURE'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mo_boot_col-sm-12 mo_boot_mt-1">
                        <div class="mo_boot_row">
                            <div class="mo_boot_col-sm-4">
                                <p><span class="mo_saml_required">*</span><strong> <?php echo JText::_('COM_MINIORANGE_SAML_DESC'); ?>:</strong></p>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <textarea  name="description" class="mo_boot_form-text-control mo_saml_proxy_setup" style="border-radius:4px;resize: vertical;width:100%;" cols="52" rows="7" onkeyup="mo_saml_valid(this)"
                                    onblur="mo_saml_valid(this)" onkeypress="mo_saml_valid(this)" required placeholder=" <?php echo JText::_('COM_MINIORANGE_SAML_TRIAL_ASSISTANCE'); ?>"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mo_boot_row mo_boot_text-center">
                    <div class="mo_boot_col-sm-12">
                        <input type="hidden" name="option1" value="mo_saml_login_send_query"/><br>
                        <input  type="submit" name="submit" value="Submit" class="mo_boot_btn mo_boot_btn-primary"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    <?php
}


function select_identity_provider()
{
    $attribute = new Mo_saml_Local_Util();
    $attribute = $attribute->_load_db_values('#__miniorange_saml_config');
    $idp_entity_id = "";
    $single_signon_service_url = "";
    $name_id_format = "";
    $certificate = "";
    $dynamicLink="Login with IDP";
    $siteUrl = JURI::root();
    $sp_base_url = $siteUrl;

    $session = JFactory::getSession();
    $current_state=$session->get('show_test_config');
    if($current_state)
    {
        ?>
        <script>
            jQuery(document).ready(function () {
                var elem = document.getElementById("test-config");
                elem.scrollIntoView();
            });
        </script>
        <?php
        $session->set('show_test_config', false);
        }
    if (isset($attribute['idp_entity_id']))
    {
        $idp_entity_id = $attribute['idp_entity_id'];
        $single_signon_service_url = $attribute['single_signon_service_url'];
        $name_id_format = $attribute['name_id_format'];
        $certificate = $attribute['certificate'];
    }
    $isAuthEnabled = JPluginHelper::isEnabled('authentication', 'miniorangesaml');
    $isSystemEnabled = JPluginHelper::isEnabled('system', 'samlredirect');
    if (!$isSystemEnabled || !$isAuthEnabled)
    {
        ?>
        <div id="system-message-container">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <div class="alert alert-error">
                <h4 class="alert-heading"><?php echo JText::_('COM_MINIORANGE_SAML_WARNING'); ?>Warning!</h4>
                <div class="alert-message">
                    <?php echo JText::_('COM_MINIORANGE_SAML_WARNING_MSG'); ?>
                </div>
            </div>
        </div>
        <?php
    } ?>
    <div class="mo_boot_row mo_boot_mr-1 mo_boot_mt-3 mo_boot_py-3 mo_boot_px-2 mo_tab_border" id="upload_metadata_form" style="display:none ;">
        <div class="mo_boot_col-sm-12 mo_boot_mt-3">
            <h3>
                <?php echo JText::_('COM_MINIORANGE_SAML_UPLOAD_METADATA_TAB'); ?><sup><a href="https://developers.miniorange.com/docs/joomla/saml-sso/saml-service-provider-setup" target="_blank" class="mo_saml_know_more" title=" <?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>"><div class="fa fa-question-circle-o"></div></a></sup>
                <span style="float:right;">
                    <input type="button" class="mo_boot_btn mo_boot_btn-danger" value="Cancel" onclick = "hide_metadata_form()"/>
                </span><hr>
            </h3>
        </div>
        <div class="mo_boot_col-sm-12 mo_boot_mt-1">
            <form action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.handle_upload_metadata'); ?>" name="metadataForm" method="post" id="IDP_meatadata_form" enctype="multipart/form-data">
                <div class="mo_boot_row mo_boot_mt-2">
                    <div class="mo_boot_col-sm-3">
                        <input id="mo_saml_upload_metadata_form_action" type="hidden" name="option1" value="upload_metadata" />
                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_UPLOAD_MEATADATA_BTN'); ?>  :</strong>
                    </div>
                    <div class="mo_boot_col-sm-7">
                        <input type="hidden" name="action"  value="upload_metadata" />
                        <input type="file"  id="metadata_uploaded_file" class="mo_boot_form-control-file"  name="metadata_file" />
                    </div>
                    <div class="mo_boot_col-sm-2">
                        <input type="button" class="mo_boot_btn mo_boot_btn-saml" id="upload_metadata_file"  name="option1" method="post" style="float:right!important" value=" <?php echo JText::_('COM_MINIORANGE_SAML_UPLOAD'); ?>"/>
                    </div>
                </div>
                <div class="mo_boot_row mo_boot_mt-2">
                    <div class="mo_boot_col-sm-12">
                        <p style="font-size:13pt;text-align:center;"><strong> <?php echo JText::_('COM_MINIORANGE_SAML_OR'); ?></strong></p>
                    </div>
                    <div class="mo_boot_col-lg-3">
                        <input type="hidden" name="action" value="fetch_metadata" />
                        <strong> <?php echo JText::_('COM_MINIORANGE_SAML_ENTER_URL'); ?>:</strong>
                    </div>
                    <div class="mo_boot_col-lg-6">
                        <input type="url" id="metadata_url" name="metadata_url" placeholder=" <?php echo JText::_('COM_MINIORANGE_SAML_ENTER_METADATA_URL'); ?>" class="mo_boot_form-control"/>
                    </div>
                    <div class="mo_boot_col-lg-3 mo_boot_text-center">
                        <input type="button" class=" mo_boot_float-lg-right mo_boot_btn mo_boot_btn-saml" name="option1" method="post" id="fetch_metadata"  value=" <?php echo JText::_('COM_MINIORANGE_SAML_FETCH_METADATA'); ?>"/>
                    </div>
                </div>
                <div class="mo_boot_row mo_boot_mt-3">
                    <div class="mo_boot_col-sm-8 mo_boot_offset-lg-3">
                        <input type="checkbox" disabled>
                        <strong> <?php echo JText::_('COM_MINIORANGE_SAML_SYNC_METADATA'); ?><a href='#' class='premium' onclick="moSAMLUpgrade();">[Enterprise]</a></strong>
                    </div>
                </div>
                <div class="mo_boot_row mo_boot_mt-3" id="select_time_sync_metadata">
                    <div class="mo_boot_col-sm-5 mo_boot_offset-lg-3">
                        <span> <?php echo JText::_('COM_MINIORANGE_SAML_SELECT_METADATA_SYNC'); ?> : </span>
                    </div>
                    <div class="mo_boot_col-sm-2">
                        <select name = "sync_interval" class="mo_boot_form-control" disabled>
                            <option value = "hourly"> <?php echo JText::_('COM_MINIORANGE_SAML_SYNC_HR'); ?></option>
                            <option value = "daily"> <?php echo JText::_('COM_MINIORANGE_SAML_SYNC_DAILY'); ?></option>
                            <option value = "weekly"> <?php echo JText::_('COM_MINIORANGE_SAML_SYNC_WEEKLY'); ?></option>
                            <option value = "monthly"> <?php echo JText::_('COM_MINIORANGE_SAML_SYNC_MONTHLY'); ?></option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="mo_boot_row  mo_boot_mr-1  mo_boot_py-3 mo_boot_px-2 mo_tab_border" id="import_export_form" style="display:none ;">
        <div class="mo_boot_col-sm-12">
            <h3>
                <?php echo JText::_('COM_MINIORANGE_SAML_IMPORT_EXPORT_CONFIG'); ?> <sup><a href="https://developers.miniorange.com/docs/joomla/saml-sso/saml-import-export-configuration" target="_blank" class="mo_saml_know_more" title="<?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>"><div class="fa fa-question-circle-o"></div></a></sup>
                <span style="float:right;">
                    <input type="button" class="mo_boot_btn mo_boot_btn-danger" value="<?php echo JText::_('COM_MINIORANGE_SAML_CANCEL'); ?>" onclick="hide_import_export_form()"/>
                </span><hr>
            </h3>
            
        </div>
        <div class="mo_boot_col-sm-12 mo_boot_mt-3">
            <div class="mo_boot_row">
                <div class="mo_boot_col-8">
                    <h4><?php echo JText::_('COM_MINIORANGE_SAML_DOWNLOAD_CONFIG'); ?>: </h4>
                </div> 
                <div class="mo_boot_col-4">
                    <form name="f" method="post" action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.importexport'); ?>">
                        <input id="mo_sp_exp_exportconfig" type="button" style="float:right" class="mo_boot_btn mo_boot_btn-saml" onclick="submit();" value= "<?php echo JText::_('COM_MINIORANGE_SAML_EXPORT_CONFIG'); ?>" />
                    </form>
                </div>
            </div>
        </div> 


        <div class="mo_boot_col-sm-12 mo_boot_mt-3"><hr> 
            <h4><?php echo JText::_('COM_MINIORANGE_SAML_IMPORT_CONFIG'); ?><sup><a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>[ Standard</strong></a>,<a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Premium</strong></a>,<a href='#' class='premium' onclick="moSAMLUpgrade();"><strong>Enterprise ]</strong></a></sup></h4>
        </div>
        <div class="mo_boot_col-12 mo_boot_mt-3">
            <div class="mo_boot_row">
                <div class="mo_boot_col-8">
                    <input type="file" class="form-control-file mo_boot_d-inline" name="configuration_file" disabled="disabled">
                </div>
                <div class="mo_boot_col-4">
                    <input id="mo_sp_exp_importconfig" type="submit" disabled="disabled" name="submit" style="float:right"class="mo_boot_btn mo_boot_btn-saml" value="<?php echo JText::_('COM_MINIORANGE_SAML_IMPORT'); ?>"/>
                </div>
            </div>
        </div>
    </div>

    <div class="mo_boot_row mo_boot_mr-1  mo_boot_p-3 mo_boot_px-2 mo_tab_border" id="tabhead">
        <div class="mo_boot_col-sm-12">
            <form action="<?php echo JRoute::_('index.php?option=com_miniorange_saml&task=myaccount.saveConfig'); ?>" method="post" name="adminForm" id="identity_provider_settings_form" enctype="multipart/form-data">
                <div class="mo_boot_row mo_boot_mt-3" >
                    <div class="mo_boot_col-lg-5">
                        <h3><?php echo JText::_('COM_MINIORANGE_SAML_SERVICE_PROVIDER_SETUP'); ?> <sup><a href="https://developers.miniorange.com/docs/joomla/saml-sso/saml-service-provider-setup" target="_blank" class="mo_saml_know_more" title="<?php echo JText::_('COM_MINIORANGE_SAML_KNOW_MORE'); ?>"><div class="fa fa-question-circle-o"></div></a></sup></h3>
                    </div>

                        <div class="mo_boot_col-lg-7 " >
                            <a href="https://plugins.miniorange.com/step-by-step-guide-for-joomla-single-sign-on-sso" target="_blank" style="float:right;margin-right: 2%;  ">
                                <span class="fa fa-file  mo_boot_btn mo_boot_btn-secondary"  >    <?php echo JText::_('COM_MINIORANGE_SAML_GUIDES'); ?></span>
                            </a>
                            <span style="margin-right:4%; float:right;">
                                <a href="https://www.youtube.com/playlist?list=PL2vweZ-PcNpdkpUxUzUCo66tZsEHJJDRl"  target="_blank">
                                    <span class="fa fa-youtube mo_boot_text-light mo_boot_btn mo_boot_btn-danger" >   <?php echo JText::_('COM_MINIORANGE_SAML_VIDEOS'); ?></span>
                                </a> 
                            </span> 
                            <input id="mo_saml_local_configuration_form_action" type="hidden" name="option1" value="mo_saml_save_config" />
                        </div>
                        <div class="mo_boot_col-sm-12">
                            <hr>
                            <div class="mo_boot_row">
                                    <div class="mo_boot_col-lg-5">
                                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_MANUAL_CONFIG'); ?></strong>
                                    </div>
                                    <div class="mo_boot_col-lg-3">
                                        <strong><?php echo JText::_('COM_MINIORANGE_SAML_OR'); ?> </strong>
                                    </div>
                                    <div class="mo_boot_col-lg-4 mo_boot_mt-1" id="tour_upload_metadata">
                                        <input id="sp_upload_metadata" type="button" class='mo_boot_btn mo_boot_btn-saml' onclick='show_metadata_form();' value="<?php echo JText::_('COM_MINIORANGE_SAML_UPLOAD_METADATA_TAB'); ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    <div id="idpdata">
                        <div class="mo_boot_row mo_boot_mt-3" id="sp_select_idp">
                            <div class="mo_boot_col-sm-4">
                                <strong><?php echo JText::_('COM_MINIORANGE_SAML_SELECT_GUIDE'); ?> <div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext" ><?php echo JText::_('COM_MINIORANGE_SAML_GUIDE_TIP'); ?></span></div></strong>
                            </div>
                            <div class="mo_boot_col-sm-8 start_dropdown">
                                <div class="mo_boot_form-control" style="width:100%;cursor:pointer" id="select_idp" ><?php echo JText::_('COM_MINIORANGE_SAML_SELECT_GUIDE'); ?><span style="float:right!important" ><i class='fa fa-angle-down'></i></span></div>
    
                                    <div id="myDropdown" class="myDropdown mo_dropdown-content">
                                                
                                        <div id="dropdown_options" class="dropdown_options" >
                                            <input type="text"  class="mo_boot_form-control" style="display:none" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_SEARCH_IDP'); ?>" id="myInput" onkeyup="filterFunction()">
                                            <div class="mo_dropdown_options" id="dropdown-test">
                                                <a href="https://plugins.miniorange.com/guide-joomla-single-sign-sso-using-adfs-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="ADFS">ADFS</a>
                                                <a href="https://plugins.miniorange.com/joomla-single-sign-sso-using-azure-ad-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Azure AD">Azure AD</a>
                                                <a href="https://plugins.miniorange.com/joomla-single-sign-sso-using-google-apps-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Google Apps">Google Apps</a>
                                                <a href="https://plugins.miniorange.com/joomla-single-sign-sso-using-okta-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Okta">Okta</a>
                                                <a href="https://plugins.miniorange.com/saml-single-sign-on-sso-for-joomla-using-office-365-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Office 365">Office 365</a>
                                                <a href="https://plugins.miniorange.com/joomla-single-sign-sso-using-salesforce-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="SalesForce">SalesForce</a>
                                                <a href="https://plugins.miniorange.com/joomla-single-sign-sso-using-onelogin-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="OneLogin">OneLogin</a>
                                                <a href="https://plugins.miniorange.com/saml-single-sign-on-sso-for-joomla-using-simplesaml-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="SimpleSAML">SimpleSAML</a>
                                                <a href="https://plugins.miniorange.com/joomla-single-sign-sso-using-miniorange-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Miniorange">Miniorange</a>
                                                <a href="https://plugins.miniorange.com/joomla-single-sign-on-sso-using-centrify-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Centrify">Centrify</a>
                                                <a href="https://plugins.miniorange.com/joomla-single-sign-sso-using-bitium-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Bitium">Bitium</a>
                                                <a href="https://plugins.miniorange.com/guide-to-configure-lastpass-as-an-idp-saml-sp" target="_blank" class="dropdown_option mo_dropdown_option" id="LastPass">LastPass</a>
                                                <a href="https://plugins.miniorange.com/guide-for-pingfederate-as-idp-with-joomla" target="_blank" class="dropdown_option mo_dropdown_option" id="Ping Federate">Ping Federate</a>
                                                <a href="https://plugins.miniorange.com/guide-for-joomla-single-sign-on-sso-using-rsa-securid-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="RSA SecureID">RSA SecureID</a>
                                                <a href="https://plugins.miniorange.com/guide-for-openam-as-idp-with-joomla" target="_blank" class="dropdown_option mo_dropdown_option" id="OpenAM">OpenAM</a>
                                                <a href="https://plugins.miniorange.com/guide-for-auth0-as-idp-with-joomla" target="_blank" class="dropdown_option mo_dropdown_option" id="Auth0">Auth0</a>
                                                <a href="https://plugins.miniorange.com/joomla-single-sign-sso-using-authanvil-ias-dp" target="_blank" class="dropdown_option mo_dropdown_option" id="Auth Anvil">Auth Anvil</a>
                                                <a href="https://plugins.miniorange.com/guide-to-setup-shibboleth2-as-idp-with-joomla" target="_blank" class="dropdown_option mo_dropdown_option" id="Shibboleth 2">Shibboleth 2</a>
                                                <a href="https://plugins.miniorange.com/guide-to-setup-shibboleth3-as-idp-with-joomla" target="_blank" class="dropdown_option mo_dropdown_option" id="Shibboleth 3">Shibboleth 3</a>
                                                <a href="https://plugins.miniorange.com/oracle-access-manager-as-idp-and-joomla-as-sp" target="_blank" class="dropdown_option mo_dropdown_option" id="Oracle Access Manager">Oracle Access Manager</a>
                                                <a href="https://plugins.miniorange.com/saml-single-sign-sso-joomla-using-wso2" target="_blank" class="dropdown_option mo_dropdown_option" id="WSO2">WSO2</a>
                                                <a href="https://plugins.miniorange.com/joomla-single-sign-sso-using-pingone-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="PingOne">PingOne</a>
                                                <a href="http://plugins.miniorange.com/joomla-single-sign-on-sso-using-jboss-keycloak-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="JBoss Keycloak">JBoss Keycloak</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-with-drupal" target="_blank" class="dropdown_option mo_dropdown_option" id="Drupal">Drupal</a>
                                                <a href="https://plugins.miniorange.com/saml-single-sign-on-sso-for-joomla-using-simplesaml-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="SimpleSAML">SimpleSAML</a>
                                                <a href="https://plugins.miniorange.com/joomla-single-sign-on-sso-using-centrify-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Centrify">Centrify</a>
                                                <a href="https://plugins.miniorange.com/guide-for-joomla-single-sign-on-sso-using-rsa-securid-as-idp" target="_blank"class="dropdown_option mo_dropdown_option" id="RSA SecureID" >RSA SecureID</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-cyberark-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="CyberArk">CyberArk</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-degreed-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Degreed">Degreed</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-duo-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Duo">Duo</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-netiq-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="NetIQ">NetIQ</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-fonteva-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Fonteva">Fonteva</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-fusionauth-as-idp"target="_blank" class="dropdown_option mo_dropdown_option" id="FusionAuth">FusionAuth</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-gluu-server-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Gluu Server">Gluu Server</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-identityserver4-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="IdentifyServer4">IdentifyServer4</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-openathens-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Openathens">Openathens</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-phenixid-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Phenixid">Phenixid</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-secureauth-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="SecureAuth">SecureAuth</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-siteminder-as-idp" target="_blank" class="dropdown_option mo_dropdown_option" id="Siteminder">Siteminder</a>
                                                <a href="https://plugins.miniorange.com/joomla-saml-single-sign-on-sso-using-surfconext-as-idp"target="_blank" class="dropdown_option mo_dropdown_option" id="Surfcontext">Surfcontext</a>
                                                <a href="https://plugins.miniorange.com/salesforce-community-saml-single-sign-on-sso-into-joomla" target="_blank" class="dropdown_option mo_dropdown_option" id="SF Community">SF Community</a>
                                                <a href="https://plugins.miniorange.com/saml-single-sign-on-sso-into-joomla-using-classlink-as-idp-classlink-sso-login" target="_blank" class="dropdown_option mo_dropdown_option" id="ClassLink">ClassLink</a>
                                                <a href="https://plugins.miniorange.com/wordpress-single-sign-on-sso-using-joomla" target="_blank" class="dropdown_option mo_dropdown_option" id="Wordpress">Wordpress</a>
                                                <a href="https://plugins.miniorange.com/absorb-lms-single-sign-on-sso-using-joomla" target="_blank" class="dropdown_option mo_dropdown_option" id="Absorb LMS">Absorb LMS</a>
                                                <a href="https://plugins.miniorange.com/absorb-lms-single-sign-on-sso-using-joomla"target="_blank"class="dropdown_option mo_dropdown_option" id="CAS Server">CAS Server</a>
                                                <a href="https://plugins.miniorange.com/step-by-step-guide-for-joomla-single-sign-on-sso" target="_blank" class="dropdown_option mo_dropdown_option" id="Custom IDP">Custom IDP</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="mo_boot_row mo_boot_mt-3" id="sp_entity_id_idp">
                            <div class="mo_boot_col-sm-4">
                                <strong><span class="mo_saml_required">*</span><?php echo JText::_('COM_MINIORANGE_SAML_IDP_ISSUER'); ?> <div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext" ><?php echo JText::_('COM_MINIORANGE_SAML_ISSUER_TIP'); ?></span></div></strong>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <input type="text" class="mo_boot_form-control mo_saml_proxy_setup" name="idp_entity_id" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_ISSUER_PLACEHOLDER'); ?>" value="<?php echo $idp_entity_id; ?>" required />
                            </div>
                        </div>
                        <div class="mo_boot_row mo_boot_mt-3" id="sp_nameid_format_idp">
                            <div class="mo_boot_col-sm-4">
                                <strong><?php echo JText::_('COM_MINIORANGE_SAML_NAMEID_FORMAT'); ?> <div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext"><?php echo JText::_('COM_MINIORANGE_SAML_NAMEID_TIP'); ?></span></div></strong>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <select class="mo_boot_form-control mo_saml_proxy_setup" id="name_id_format" name="name_id_format">
                                    <option value="urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress"
                                        <?php if ($name_id_format == "urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress") echo 'selected = "selected"' ?>>
                                        urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress
                                    </option>
                                    <option value="urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified"
                                        <?php if ($name_id_format == "urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified") echo 'selected = "selected"' ?>>
                                        urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified
                                    </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mo_boot_row mo_boot_mt-3" id="sp_sso_url_idp">
                            <div class="mo_boot_col-sm-4">
                                <strong><span class="mo_saml_required">*</span><?php echo JText::_('COM_MINIORANGE_SAML_IDP_SSO_URL'); ?> <div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext"><?php echo JText::_('COM_MINIORANGE_SAML_IDP_SSO_TIP'); ?></span></div></strong>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <input class="mo_saml_table_textbox mo_boot_form-control mo_saml_proxy_setup" type="url" placeholder="Single Sign-On Service URL (Http-Redirect) binding of your IdP" name="single_signon_service_url"  value="<?php echo $single_signon_service_url; ?>" required />
                            </div>
                        </div>
                        <div class="mo_boot_row mo_boot_mt-3" id="sp_certificate_idp">
                            <div class="mo_boot_col-sm-4">
                                <strong>X.509 Certificate <div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext"><?php echo JText::_('COM_MINIORANGE_SAML_CRT_FORMAT'); ?> :<br>
                                                    ---BEGIN CERTIFICATE---<br>
                                                    XXXXXXXXXXXXXX<br>
                                                    ---END CERTIFICATE---</span></div></strong>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <div class="mo_boot_row">
                                    <div class="mo_boot_col-lg-4">
                                        <label>   <input type="radio" name="cert"  value="text_cert" CHECKED ><?php echo JText::_('COM_MINIORANGE_SAML_ENTER_TEXT'); ?></label>
                                    </div>
                                    <div class="mo_boot_col-lg-5">
                                        <label><input type="radio" name="cert"  value="upload_cert" > <?php echo JText::_('COM_MINIORANGE_SAML_UPLOAD_CRT'); ?></label>
                                    </div>
                                </div>
                                <div class="upload_cert selectt" >
                                    <div class="mo_saml_border">
                                            <input type="file" id="myFile" name="myFile" class="mo_certficate_file" >
                                    </div>
                                    <span id="uploaded_cert"></span>
                                </div>
                                <div class="text_cert selectt">
                                    <textarea rows="5" cols="80" name="certificate" class="mo_boot_form-text-control mo_saml_proxy_setup" placeholder="<?php echo JText::_('COM_MINIORANGE_SAML_CRT_TIP'); ?>"><?php echo $certificate; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mo_boot_row mo_boot_mt-3" id="saml_login">
                            <div class="mo_boot_col-sm-4">
                                <strong><?php echo JText::_('COM_MINIORANGE_SAML_ENABLE_BTN'); ?><div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext" ><?php echo JText::_('COM_MINIORANGE_SAML_ADD_LINK'); ?> </span></div></strong>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <input type="checkbox" id ="login_link_check" name="login_link_check" class="mo_saml_custom_checkbox" onclick="showLink()" value="1"
                                        <?php 
                                            $count = isset($attribute['login_link_check']) ? $attribute['login_link_check'] : "";
                                            $dynamicLink=isset($attribute['dynamic_link']) && !empty($attribute['dynamic_link']) ? $attribute['dynamic_link'] : "";
                                            if($count ==1)                        
                                                echo 'checked="checked"';                           
                                            else
                                                $dynamicLink="Login with your IDP";
                                        ?>
                                >
                                <input type="text" id="dynamicText" name="dynamic_link" placeholder="Enter your IDP Name" value="<?php echo $dynamicLink; ?>" class="mo_boot_form-control mo_boot_mt-3 mo_boot_my-3" >
                                <?php
                                    if($count!=1)
                                    {
                                        echo '<script>document.getElementById("dynamicText").style.display="none"</script>';
                                    }
                                ?>
                            </div><br><br><br>
                            <div class="mo_boot_col-sm-4">
                                <strong><?php echo JText::_('COM_MINIORANGE_SAML_SSO_URL'); ?> <div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext" ><?php echo JText::_('COM_MINIORANGE_SAML_SSO_URL_TIP'); ?></span></div></strong>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <div class="mo_saml_highlight_background_url_note">
                                    <div class="mo_boot_row">
                                        <div class="mo_boot_col-10">
                                            <span id="show_sso_url" style="color:#2a69b8">
                                                <strong><?php echo  $sp_base_url . '?morequest=sso'; ?></strong>
                                            </span>
                                        </div>
                                        <div class="mo_boot_col-2">
                                            <em class="fa fa-lg fa-copy mo_copy_sso_url mo_copytooltip" onclick="copyToClipboard('#show_sso_url');"><span class="mo_copytooltiptext copied_text"><?php echo JText::_('COM_MINIORANGE_SAML_COPY_BTN'); ?></span> </em>   
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div><br>
                        <details !important>
                            <summary class="mo_saml_main_summary" ><?php echo JText::_('COM_MINIORANGE_SAML_PREMIUM_VERSIONS_FEATURE'); ?><sup><strong><a href='#' class='premium' onclick="moSAMLUpgrade();"> [Standard, Premium, Enterprise]</a></strong></sup></summary><hr>
                        <div class="mo_boot_row mo_boot_mt-3" id="sp_slo_idp">
                            <div class="mo_boot_col-sm-4">
                                <strong><?php echo JText::_('COM_MINIORANGE_SAML_IDP_SLO'); ?> <div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext"><?php echo JText::_('COM_MINIORANGE_SAML_SLO_TIP'); ?><strong><a href='#' class='premium' onclick="moSAMLUpgrade();">[Premium, Enterprise]</a></strong></span></div></strong>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <input class="mo_saml_table_textbox mo_boot_form-control" type="text" name="single_logout_url" placeholder="Single Logout URL" disabled>
                            </div>
                        </div>
                        <div class="mo_boot_row mo_boot_mt-3">
                            <div class="mo_boot_col-sm-4">
                                <strong><?php echo JText::_('COM_MINIORANGE_SAML_SIGN_ALGO'); ?> <div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext"><?php echo JText::_('COM_MINIORANGE_SAML_SIGN_ALGO_TIP'); ?><strong><a href='#' class='premium' onclick="moSAMLUpgrade();">[Enterprise]</a></strong></span></div></strong>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <select class="mo_boot_form-control mo_saml_proxy_setup" disabled>
                                    <option>sha256</option>
                                </select>
                            </div>
                        </div>
                        <div class="mo_boot_row mo_boot_mt-3" id="sp_binding_type">
                            <div class="mo_boot_col-sm-4">
                                <strong><?php echo JText::_('COM_MINIORANGE_SAML_SELECT_BIND'); ?><div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext"><strong><a href='#' class='premium' onclick="moSAMLUpgrade();"> [Standard, Premium, Enterprise]</a></strong></span></div></strong>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <input type="radio" name="miniorange_saml_idp_sso_binding" value="HttpRedirect" checked=1 aria-invalid="false" disabled> <span><?php echo JText::_('COM_MINIORANGE_SAML_BIND_ONE'); ?></span><br>
                                <input type="radio"  name="miniorange_saml_idp_sso_binding" value="HttpPost" aria-invalid="false" disabled> <span><?php echo JText::_('COM_MINIORANGE_SAML_BIND_TWO'); ?> </span>
                            </div>
                        </div>
                        <div class="mo_boot_row mo_boot_mt-3" id="sp_saml_request_idp">
                            <div class="mo_boot_col-sm-4">
                                <strong><?php echo JText::_('COM_MINIORANGE_SAML_SIGN_SLO'); ?> <div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext"><strong><a href='#' class='premium' onclick="moSAMLUpgrade();"> [Standard, Premium, Enterprise]</a></strong></span></div></strong>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <input type="checkbox" name="saml_request_sign mo_saml_proxy_setup" disabled>
                            </div>
                        </div>
                        <div class="mo_boot_row mo_boot_mt-3" id="sp_saml_context_class">
                            <div class="mo_boot_col-sm-4">
                                <strong><?php echo JText::_('COM_MINIORANGE_SAML_CONTEXT'); ?> <div class="fa fa-question-circle-o mo_tooltip"><span class="mo_tooltiptext"><?php echo JText::_('COM_MINIORANGE_SAML_CONTEXT_TIP'); ?></span></div></strong>
                            </div>
                            <div class="mo_boot_col-sm-8">
                                <select class="mo_boot_form-control mo_saml_proxy_setup"  disabled>
                                    <option>PasswordProtectedTransport</option>
                                </select>
                            </div>
                        </div><br>
                        </details>
                        
                        <div class="mo_boot_row mo_boot_mt-5">
                            <div class="mo_boot_col-sm-12 mo_boot_text-center">
                                <input type="submit" class="mo_boot_btn mo_boot_btn-success" value="<?php echo JText::_('COM_MINIORANGE_SAML_SAVE_BTN'); ?>"/>
                                <input  type="button" id='test-config' <?php if ($idp_entity_id) echo "enabled";else echo "disabled"; ?> title='<?php echo JText::_('COM_MINIORANGE_SAML_TEST_CONFIG_TITLE'); ?>' class="mo_boot_btn mo_boot_btn-saml" onclick='showTestWindow()' value="<?php echo JText::_('COM_MINIORANGE_SAML_TEST_CONFIG'); ?>">
                                <a href="#import_export_form" type="button" class="mo_boot_btn mo_boot_btn-saml" onclick="show_import_export()"><?php echo JText::_('COM_MINIORANGE_SAML_IMPORT_EXPORT'); ?></a>
                                </div>
                            </div>
                </div>
            </form>
        </div>
    </div>
    <?php
}
