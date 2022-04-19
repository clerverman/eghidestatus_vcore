<?php
/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
} 

class Eghidestatus extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'eghidestatus';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Slimani mouhcine';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Eghidestatus');
        $this->description = $this->l('eghidestatus ........');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {  
        return parent::install() &&
            $this->registerHook('header') && 
            $this->registerHook('backOfficeHeader');
    }

    public function uninstall()
    {   
        return parent::uninstall();
    }


    private function masquer($t)
    {
        for($i = 0 ; $i < count($t[0]) ; $i++) 
            Db::getInstance()->execute(
                'UPDATE `'._DB_PREFIX_.'order_state` SET `deleted` = 1 WHERE `id_order_state` = '. $t[0][$i]);
    }
    
    private function démasquer($t)
    {
        for($i = 0 ; $i < count($t[0]) ; $i++)
                    Db::getInstance()->execute(
                        'UPDATE `'._DB_PREFIX_.'order_state` SET `deleted` = 0 where `id_order_state` = '.$t[0][$i]);
    }

    private function listeDeroulante()
    {
       $res =  Db::getInstance()->executeS('
            SELECT id_order_state , name 
            FROM `' . _DB_PREFIX_ . 'order_state_lang` os where id_lang = 1');
        return $res ; 
    }

    public function getContent()
    {    
        $warning  = "" ; 
        if(Tools::isSubmit('mybtn')){
            $t[] = Tools::getValue("status") ; 
            if(Tools::getValue("choice")== "active") 
                $this->masquer($t) ;  
            else if (Tools::getValue("choice")== "desactiver")
                $this->démasquer($t) ;  
            else 
                $warning .= "Veuillez cocher soit activé ou désactiver la fonctionalité !!!" ; 
        }
        $result = $this->listeDeroulante() ;
        $this->context->smarty->assign(["result"=>$result,"warning"=>$warning]) ; 
        return $this->display(__FILE__,"/views/templates/admin/configure.tpl") ; 
    }
 
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS([$this->_path.'views/js/back.js',$this->_path.'views/js/jquery.js']);
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }
 
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

   
}