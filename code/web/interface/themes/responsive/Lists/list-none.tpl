{strip}
{* Recommendations *}
{if $topRecommendations}
	{foreach from=$topRecommendations item="recommendations"}
		{include file=$recommendations}
	{/foreach}
{/if}

	<h2>{translate text='nohit_heading'}</h2>

<p class="alert alert-info">{translate text='nohit_prefix'} - <b>{if $lookfor}{$lookfor|escape:"html"}{else}&lt;empty&gt;{/if}</b> - {translate text='nohit_suffix'}</p>

{* Return to Advanced Search Link *}
{if $searchType == 'advanced'}
	<h5>
		<a href="{$path}/Search/Advanced">Edit This Advanced Search</a>
	</h5>
{/if}

{if $solrSearchDebug}
	<div id="solrSearchOptionsToggle" onclick="$('#solrSearchOptions').toggle()">Show Search Options</div>
	<div id="solrSearchOptions" style="display:none">
		<pre>Search options: {$solrSearchDebug}</pre>
	</div>
{/if}

{if $solrLinkDebug}
	<div id='solrLinkToggle' onclick='$("#solrLink").toggle()'>Show Solr Link</div>
	<div id='solrLink' style='display:none'>
		<pre>{$solrLinkDebug}</pre>
	</div>
{/if}

<div>
	{if !empty($parseError)}
		<div class="alert alert-danger">
			{$parseError}
		</div>
	{/if}

	{include file="Search/spellingSuggestions.tpl"}

	{include file="Search/searchSuggestions.tpl"}

	{if $showExploreMoreBar}
		<div id="explore-more-bar-placeholder"></div>
		<script type="text/javascript">
			$(document).ready(
					function () {ldelim}
						AspenDiscovery.Searches.loadExploreMoreBar('open_archives', '{$exploreMoreSearchTerm|escape:"html"}');
						{rdelim}
			);
		</script>
	{/if}

	{if $showSearchTools || ($loggedIn && (array_key_exists('opacAdmin', $userRoles) || array_key_exists('libraryAdmin', $userRoles) || array_key_exists('contentEditor', $userRoles)))}
		<div class="search_tools well small">
			<strong>{translate text='Search Tools'}:</strong>
			{if $showSearchTools}
				<a href="{$rssLink|escape}"><span class="silk feed">&nbsp;</span>{translate text='Get RSS Feed'}</a>
				<a href="#" onclick="return AspenDiscovery.Account.ajaxLightbox('{$path}/Search/AJAX?method=getEmailForm', true);"><span class="silk email">&nbsp;</span>{translate text='Email this Search'}</a>
				{if $savedSearch}
					<a href="#" onclick="return AspenDiscovery.Account.saveSearch('{$searchId}')"><span class="silk delete">&nbsp;</span>{translate text='save_search_remove'}</a>
				{else}
					<a href="#" onclick="return AspenDiscovery.Account.saveSearch('{$searchId}')"><span class="silk add">&nbsp;</span>{translate text='save_search'}</a>
				{/if}
				<a href="{$excelLink|escape}"><span class="silk table_go">&nbsp;</span>{translate text='Export To Excel'}</a>
			{/if}
			{if $loggedIn && (array_key_exists('opacAdmin', $userRoles) || array_key_exists('libraryAdmin', $userRoles) || array_key_exists('contentEditor', $userRoles))}
				<a href="#" onclick="return AspenDiscovery.ListWidgets.createWidgetFromSearch('{$searchId}')"><span class="silk cog_go">&nbsp;</span>{translate text='Create Widget'}</a>
			{/if}
			{if $loggedIn && (array_key_exists('opacAdmin', $userRoles) || array_key_exists('libraryAdmin', $userRoles) || array_key_exists('contentEditor', $userRoles))}
				<a href="#" onclick="return AspenDiscovery.Browse.addToHomePage('{$searchId}')"><span class="silk cog_go">&nbsp;</span>{translate text='Add To Home Page as Browse Category'}</a>
			{/if}
		</div>
	{/if}

</div>
{/strip}