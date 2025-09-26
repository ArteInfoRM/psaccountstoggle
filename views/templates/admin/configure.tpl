{*
**
*  2009-2025 Arte e Informatica
*
*  For support feel free to contact us on our website at http://www.tecnoacquisti.com
*
*  @author    Arte e Informatica <helpdesk@tecnoacquisti.com>
*  @copyright 2009-2025 Arte e Informatica
*  @version   1.0.0
*  @license   One Paid Licence By WebSite Using This Module. No Rent. No Sell. No Share.
*
*}
<div class="panel">
	<h3><i class="icon-code"></i> {l s='Documentation' mod='psaccountstoggle'}</h3>
	<p>
		{l s='PS_ACCOUNTS_LOGIN_ENABLED is an internal, undocumented setting of the ps_accounts module used to enable the login flow through a PrestaShop Addons Account.'  mod='psaccountstoggle'}<br />
		{l s='However, this approach can be inconvenient in environments with multiple employees, where the alternative login may feel frustrating.'  mod='psaccountstoggle'}<br />
		{l s='This module allows you to easily enable or disable this setting at will, without affecting the other features of ps_accounts.'  mod='psaccountstoggle'}
	</p>
	{if $ps_account == 0}
	<div class="alert alert-info">
		{l s='The ps_account module is not installed' mod='psaccountstoggle'}
	</div>
	{/if}
</div>
