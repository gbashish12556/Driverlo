<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_admininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$tbl_admin_delete = NULL; // Initialize page object first

class ctbl_admin_delete extends ctbl_admin {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}";

	// Table name
	var $TableName = 'tbl_admin';

	// Page object name
	var $PageObjName = 'tbl_admin_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-error ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<table class=\"ewStdTable\"><tr><td><div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div></td></tr></table>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (tbl_admin)
		if (!isset($GLOBALS["tbl_admin"]) || get_class($GLOBALS["tbl_admin"]) == "ctbl_admin") {
			$GLOBALS["tbl_admin"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_admin"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_admin', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		$Security->TablePermission_Loaded();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("tbl_adminlist.php");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->fld_admin_ai_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("tbl_adminlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tbl_admin class, tbl_admininfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->fld_admin_ai_id->setDbValue($rs->fields('fld_admin_ai_id'));
		$this->fld_user_name->setDbValue($rs->fields('fld_user_name'));
		$this->fld_password->setDbValue($rs->fields('fld_password'));
		$this->fld_is_active->setDbValue($rs->fields('fld_is_active'));
		$this->fld_created_on->setDbValue($rs->fields('fld_created_on'));
		$this->fld_level->setDbValue($rs->fields('fld_level'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->fld_admin_ai_id->DbValue = $row['fld_admin_ai_id'];
		$this->fld_user_name->DbValue = $row['fld_user_name'];
		$this->fld_password->DbValue = $row['fld_password'];
		$this->fld_is_active->DbValue = $row['fld_is_active'];
		$this->fld_created_on->DbValue = $row['fld_created_on'];
		$this->fld_level->DbValue = $row['fld_level'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// fld_admin_ai_id
		// fld_user_name
		// fld_password
		// fld_is_active
		// fld_created_on
		// fld_level

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// fld_admin_ai_id
			$this->fld_admin_ai_id->ViewValue = $this->fld_admin_ai_id->CurrentValue;
			$this->fld_admin_ai_id->ViewCustomAttributes = "";

			// fld_user_name
			$this->fld_user_name->ViewValue = $this->fld_user_name->CurrentValue;
			$this->fld_user_name->ViewCustomAttributes = "";

			// fld_password
			$this->fld_password->ViewValue = $this->fld_password->CurrentValue;
			$this->fld_password->ViewCustomAttributes = "";

			// fld_is_active
			if (ew_ConvertToBool($this->fld_is_active->CurrentValue)) {
				$this->fld_is_active->ViewValue = $this->fld_is_active->FldTagCaption(1) <> "" ? $this->fld_is_active->FldTagCaption(1) : "1";
			} else {
				$this->fld_is_active->ViewValue = $this->fld_is_active->FldTagCaption(2) <> "" ? $this->fld_is_active->FldTagCaption(2) : "0";
			}
			$this->fld_is_active->ViewCustomAttributes = "";

			// fld_created_on
			$this->fld_created_on->ViewValue = $this->fld_created_on->CurrentValue;
			$this->fld_created_on->ViewValue = ew_FormatDateTime($this->fld_created_on->ViewValue, 9);
			$this->fld_created_on->ViewCustomAttributes = "";

			// fld_level
			if ($Security->CanAdmin()) { // System admin
			if (strval($this->fld_level->CurrentValue) <> "") {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->fld_level->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->fld_level, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->fld_level->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->fld_level->ViewValue = $this->fld_level->CurrentValue;
				}
			} else {
				$this->fld_level->ViewValue = NULL;
			}
			} else {
				$this->fld_level->ViewValue = "********";
			}
			$this->fld_level->ViewCustomAttributes = "";

			// fld_admin_ai_id
			$this->fld_admin_ai_id->LinkCustomAttributes = "";
			$this->fld_admin_ai_id->HrefValue = "";
			$this->fld_admin_ai_id->TooltipValue = "";

			// fld_user_name
			$this->fld_user_name->LinkCustomAttributes = "";
			$this->fld_user_name->HrefValue = "";
			$this->fld_user_name->TooltipValue = "";

			// fld_password
			$this->fld_password->LinkCustomAttributes = "";
			$this->fld_password->HrefValue = "";
			$this->fld_password->TooltipValue = "";

			// fld_is_active
			$this->fld_is_active->LinkCustomAttributes = "";
			$this->fld_is_active->HrefValue = "";
			$this->fld_is_active->TooltipValue = "";

			// fld_created_on
			$this->fld_created_on->LinkCustomAttributes = "";
			$this->fld_created_on->HrefValue = "";
			$this->fld_created_on->TooltipValue = "";

			// fld_level
			$this->fld_level->LinkCustomAttributes = "";
			$this->fld_level->HrefValue = "";
			$this->fld_level->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['fld_admin_ai_id'];
				$this->LoadDbValues($row);
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "tbl_adminlist.php", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, ew_CurrentUrl());
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_admin_delete)) $tbl_admin_delete = new ctbl_admin_delete();

// Page init
$tbl_admin_delete->Page_Init();

// Page main
$tbl_admin_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_admin_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_admin_delete = new ew_Page("tbl_admin_delete");
tbl_admin_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = tbl_admin_delete.PageID; // For backward compatibility

// Form object
var ftbl_admindelete = new ew_Form("ftbl_admindelete");

// Form_CustomValidate event
ftbl_admindelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_admindelete.ValidateRequired = true;
<?php } else { ?>
ftbl_admindelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_admindelete.Lists["x_fld_level"] = {"LinkField":"x_userlevelid","Ajax":null,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($tbl_admin_delete->Recordset = $tbl_admin_delete->LoadRecordset())
	$tbl_admin_deleteTotalRecs = $tbl_admin_delete->Recordset->RecordCount(); // Get record count
if ($tbl_admin_deleteTotalRecs <= 0) { // No record found, exit
	if ($tbl_admin_delete->Recordset)
		$tbl_admin_delete->Recordset->Close();
	$tbl_admin_delete->Page_Terminate("tbl_adminlist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_admin_delete->ShowPageHeader(); ?>
<?php
$tbl_admin_delete->ShowMessage();
?>
<form name="ftbl_admindelete" id="ftbl_admindelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_admin">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tbl_admin_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_admindelete" class="ewTable ewTableSeparate">
<?php echo $tbl_admin->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($tbl_admin->fld_admin_ai_id->Visible) { // fld_admin_ai_id ?>
		<td><span id="elh_tbl_admin_fld_admin_ai_id" class="tbl_admin_fld_admin_ai_id"><?php echo $tbl_admin->fld_admin_ai_id->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_admin->fld_user_name->Visible) { // fld_user_name ?>
		<td><span id="elh_tbl_admin_fld_user_name" class="tbl_admin_fld_user_name"><?php echo $tbl_admin->fld_user_name->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_admin->fld_password->Visible) { // fld_password ?>
		<td><span id="elh_tbl_admin_fld_password" class="tbl_admin_fld_password"><?php echo $tbl_admin->fld_password->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_admin->fld_is_active->Visible) { // fld_is_active ?>
		<td><span id="elh_tbl_admin_fld_is_active" class="tbl_admin_fld_is_active"><?php echo $tbl_admin->fld_is_active->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_admin->fld_created_on->Visible) { // fld_created_on ?>
		<td><span id="elh_tbl_admin_fld_created_on" class="tbl_admin_fld_created_on"><?php echo $tbl_admin->fld_created_on->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_admin->fld_level->Visible) { // fld_level ?>
		<td><span id="elh_tbl_admin_fld_level" class="tbl_admin_fld_level"><?php echo $tbl_admin->fld_level->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tbl_admin_delete->RecCnt = 0;
$i = 0;
while (!$tbl_admin_delete->Recordset->EOF) {
	$tbl_admin_delete->RecCnt++;
	$tbl_admin_delete->RowCnt++;

	// Set row properties
	$tbl_admin->ResetAttrs();
	$tbl_admin->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tbl_admin_delete->LoadRowValues($tbl_admin_delete->Recordset);

	// Render row
	$tbl_admin_delete->RenderRow();
?>
	<tr<?php echo $tbl_admin->RowAttributes() ?>>
<?php if ($tbl_admin->fld_admin_ai_id->Visible) { // fld_admin_ai_id ?>
		<td<?php echo $tbl_admin->fld_admin_ai_id->CellAttributes() ?>>
<span id="el<?php echo $tbl_admin_delete->RowCnt ?>_tbl_admin_fld_admin_ai_id" class="control-group tbl_admin_fld_admin_ai_id">
<span<?php echo $tbl_admin->fld_admin_ai_id->ViewAttributes() ?>>
<?php echo $tbl_admin->fld_admin_ai_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_admin->fld_user_name->Visible) { // fld_user_name ?>
		<td<?php echo $tbl_admin->fld_user_name->CellAttributes() ?>>
<span id="el<?php echo $tbl_admin_delete->RowCnt ?>_tbl_admin_fld_user_name" class="control-group tbl_admin_fld_user_name">
<span<?php echo $tbl_admin->fld_user_name->ViewAttributes() ?>>
<?php echo $tbl_admin->fld_user_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_admin->fld_password->Visible) { // fld_password ?>
		<td<?php echo $tbl_admin->fld_password->CellAttributes() ?>>
<span id="el<?php echo $tbl_admin_delete->RowCnt ?>_tbl_admin_fld_password" class="control-group tbl_admin_fld_password">
<span<?php echo $tbl_admin->fld_password->ViewAttributes() ?>>
<?php echo $tbl_admin->fld_password->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_admin->fld_is_active->Visible) { // fld_is_active ?>
		<td<?php echo $tbl_admin->fld_is_active->CellAttributes() ?>>
<span id="el<?php echo $tbl_admin_delete->RowCnt ?>_tbl_admin_fld_is_active" class="control-group tbl_admin_fld_is_active">
<span<?php echo $tbl_admin->fld_is_active->ViewAttributes() ?>>
<?php echo $tbl_admin->fld_is_active->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_admin->fld_created_on->Visible) { // fld_created_on ?>
		<td<?php echo $tbl_admin->fld_created_on->CellAttributes() ?>>
<span id="el<?php echo $tbl_admin_delete->RowCnt ?>_tbl_admin_fld_created_on" class="control-group tbl_admin_fld_created_on">
<span<?php echo $tbl_admin->fld_created_on->ViewAttributes() ?>>
<?php echo $tbl_admin->fld_created_on->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_admin->fld_level->Visible) { // fld_level ?>
		<td<?php echo $tbl_admin->fld_level->CellAttributes() ?>>
<span id="el<?php echo $tbl_admin_delete->RowCnt ?>_tbl_admin_fld_level" class="control-group tbl_admin_fld_level">
<span<?php echo $tbl_admin->fld_level->ViewAttributes() ?>>
<?php echo $tbl_admin->fld_level->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tbl_admin_delete->Recordset->MoveNext();
}
$tbl_admin_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ftbl_admindelete.Init();
</script>
<?php
$tbl_admin_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_admin_delete->Page_Terminate();
?>
