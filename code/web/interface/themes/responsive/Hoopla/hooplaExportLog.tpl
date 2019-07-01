{strip}
	<div id="main-content" class="col-md-12">
		<h3>{translate text="Hoopla Export Log"}</h3>
		<hr>

		<h4>{translate text="Filter by"}</h4>

		<form class="navbar form-inline row">
			<div class="form-group col-xs-5">
				<span class="pull-right">
					<label for="pageSize" class="control-label">{translate text="Entries Per Page"}&nbsp;</label>
					<select id="pageSize" name="pageSize" class="pageSize form-control input-sm" onchange="AspenDiscovery.changePageSize()">
						<option value="30"{if $recordsPerPage == 30} selected="selected"{/if}>30</option>
						<option value="50"{if $recordsPerPage == 50} selected="selected"{/if}>50</option>
						<option value="75"{if $recordsPerPage == 75} selected="selected"{/if}>75</option>
						<option value="100"{if $recordsPerPage == 100} selected="selected"{/if}>100</option>
					</select>
				</span>
			</div>
		</form>
		<div id="hooplaExportLogContainer">
			<table class="logEntryDetails table table-condensed table-hover">
				<thead>
					<tr><th>{translate text="Id"}</th><th>{translate text="Started"}</th><th>{translate text="Last Update"}</th><th>{translate text="Finished"}</th><th>{translate text="Elapsed"}</th><th>{translate text="Total Products"}</th><th>{translate text="Num Errors"}</th><th>{translate text="Products Added"}</th><th>{translate text="Products Deleted"}</th><th>{translate text="Products Updated"}</th><th>{translate text="Products Skipped"}</th><th>{translate text="Notes"}</th></tr>
				</thead>
				<tbody>
					{foreach from=$logEntries item=logEntry}
						<tr>
							<td>{$logEntry->id}</td>
							<td>{$logEntry->startTime|date_format:"%D %T"}</td>
							<td>{$logEntry->lastUpdate|date_format:"%D %T"}</td>
							<td>{$logEntry->endTime|date_format:"%D %T"}</td>
							<td>{$logEntry->getElapsedTime()}</td>
							<td>{$logEntry->numProducts}</td>
							<td>{$logEntry->numErrors}</td>
							<td>{$logEntry->numAdded}</td>
							<td>{$logEntry->numDeleted}</td>
							<td>{$logEntry->numUpdated}</td>
							<td>{$logEntry->numSkipped}</td>
							<td><a href="#" onclick="return AspenDiscovery.Admin.showExtractNotes('{$logEntry->id}', 'hoopla');">{translate text="Show Notes"}</a></td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>

		{if $pageLinks.all}<div class="text-center">{$pageLinks.all}</div>{/if}
	</div>
{/strip}