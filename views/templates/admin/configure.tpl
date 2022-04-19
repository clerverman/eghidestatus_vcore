{*
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
*}

{if !empty($warning)} 
<div class="alert medium-alert alert-warning" role="alert">
  <p class="alert-text">
   {$warning}
  </p>
</div>
{/if}

<div class="panel">
	<h3><i class="icon icon-credit-card"></i> {l s='La liste des status' mod='eghidestatus'}</h3>
	<div class="form-group">
		<form method="post">

			{if isset($result) && !empty($result)} 
 				<select name="status[]" multiple class="from-control" id="listeStatus">
						{foreach from=$result item=res}
							<option value="{$res.id_order_state}">{$res.name}</option>
						{/foreach}
				</select>
			{/if}

		   
	<br> 
		<div class="form-group">
			<div class="md-checkbox">
				<label>
				<input type="checkbox" name="choice" value="active"/>
				<i class="md-checkbox-control"></i>
					Activer
				</label>
			</div>
			<div class="md-checkbox">
				<label>
				<input type="checkbox" name="choice" value="desactiver"/>
				<i class="md-checkbox-control"></i>
					Désactiver 
				</label>
			</div>
		</div>
		<div class="panel-footer">
			<button type="submit" class="btn btn-primary btn-sm pull-right" name="mybtn" > 
			{l s='Sauvegarder' mod='eghidestatus'} 
			</button>
		</div>
	</form>
</div>

<script>
	
$('#mybtn').click(function() {
	alert($("#listeStatus :selected").val().length);
})
</script>
