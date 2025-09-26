<?php
/**
 * 2009-2025 Tecnoacquisti.com
 *
 * For support feel free to contact us on our website at http://www.tecnoacquisti.com
 *
 * @author    Arte e Informatica <helpdesk@tecnoacquisti.com>
 * @copyright 2009-2025 Arte e Informatica
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @version   1.0.0
 */
if (!defined('_PS_VERSION_')) { exit; }

class PsAccountsToggle extends Module
{
    public function __construct()
    {
        $this->name = 'psaccountstoggle';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Tecnoacquisti.com';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('PS Accounts Toggle');
        $this->description = $this->l('PS_ACCOUNTS_LOGIN_ENABLED is an internal, undocumented setting of the ps_accounts module used to enable the login flow through a PrestaShop Addons account. This module allows you to easily enable or disable this setting at will, without affecting the other features of ps_accounts.');
    }

    public function install()
    {
        return parent::install();
    }

    public function uninstall()
    {
         return parent::uninstall();
    }

    protected function checkPsAccountsInstalled()
    {
        return Module::isInstalled('ps_accounts');
    }

    public function getContent()
    {
        $output = '';
        $installed = false;

        if (Tools::isSubmit('submitPsAccountsToggle')) {
            $this->postProcess();
            $output .= $this->displayConfirmation($this->l('Saved settings.'));
            // Optional: Clear smarty cache for security
            try { Tools::clearSmartyCache(); } catch (\Exception $e) {}
        }

        if ($this->checkPsAccountsInstalled()) {
                $installed = true;
        }

        $this->context->smarty->assign([
            'ps_account' => $installed,
            'module_dir' => $this->_path
        ]);

        $output .= $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.tpl');
        return $output . $this->renderForm();

    }

    protected function postProcess()
    {

        $enabled = (bool)Tools::getValue('PS_ACCOUNTS_LOGIN_ENABLED');

        Configuration::updateValue(
            'PS_ACCOUNTS_LOGIN_ENABLED',
            (string)(int)$enabled,
        );

    }

    protected function renderForm()
    {
        $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');

        // Value read respecting the current context
        $ctx = Shop::getContext();
        $idShop = ($ctx === Shop::CONTEXT_SHOP) ? (int)$this->context->shop->id : null;
        $idGroup = ($ctx === Shop::CONTEXT_GROUP) ? (int)$this->context->shop->id_shop_group : null;
        $current = Configuration::get('PS_ACCOUNTS_LOGIN_ENABLED', null, $idGroup, $idShop);

        $fieldsForm = [
            'form' => [
                'legend' => ['title' => $this->l('PS Accounts Settings')],
                'input'  => [
                    [
                        'type'    => 'switch',
                        'label'   => $this->l('Enable PS Accounts login'),
                        'name'    => 'PS_ACCOUNTS_LOGIN_ENABLED',
                        'is_bool' => true,
                        'desc'    => $this->l('When OFF, login handled by the ps_accounts module is disabled, reverting to the standard PS login.'),
                        'values'  => [
                            ['id' => 'on',  'value' => 1, 'label' => $this->l('Yes')],
                            ['id' => 'off', 'value' => 0, 'label' => $this->l('No')],
                        ],
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                    'name'  => 'submitPsAccountsToggle'
                ],
            ],
        ];

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->default_form_language = $defaultLang;
        $helper->allow_employee_form_lang = (int)Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
        $helper->module = $this;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitPsAccountsToggle';
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->fields_value = [
            'PS_ACCOUNTS_LOGIN_ENABLED' => (int)(bool)$current,
        ];

        return $helper->generateForm([$fieldsForm]);

    }

}

