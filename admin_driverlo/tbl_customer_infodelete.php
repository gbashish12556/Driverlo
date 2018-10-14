<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_customer_infoinfo.php" ?>
<?php include_once "tbl_admininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$tbl_customer_info_delete = NULL; // Initialize page object first

class ctbl_customer_info_delete extends ctbl_customer_info {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}";

	// Table name
	var $TableName = 'tbl_customer_info';

	// Page object name
	var $PageObjName = 'tbl_customer_info_delete';

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

		// Table object (tbl_customer_info)
		if (!isset($GLOBALS["tbl_customer_info"]) || get_class($GLOBALS["tbl_customer_info"]) == "ctbl_customer_info") {
			$GLOBALS["tbl_customer_info"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_customer_info"];
		}

		// Table object (tbl_admin)
		if (!isset($GLOBALS['tbl_admin'])) $GLOBALS['tbl_admin'] = new ctbl_admin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_customer_info', TRUE);

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
			$this->Page_Terminate("tbl_customer_infolist.php");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->fld_customer_ai_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->Page_Terminate("tbl_customer_infolist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tbl_customer_info class, tbl_customer_infoinfo.php

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
		$this->fld_customer_ai_id->setDbValue($rs->fields('fld_customer_ai_id'));
		$this->fld_email->setDbValue($rs->fields('fld_email'));
		$this->fld_name->setDbValue($rs->fields('fld_name'));
		$this->fld_mobile_no->setDbValue($rs->fields('fld_mobile_no'));
		$this->fld_password->setDbValue($rs->fields('fld_password'));
		$this->fld_rating->setDbValue($rs->fields('fld_rating'));
		$this->fld_user_token->setDbValue($rs->fields('fld_user_token'));
		$this->fld_device_id->setDbValue($rs->fields('fld_device_id'));
		$this->fld_gcm_regid->setDbValue($rs->fields('fld_gcm_regid'));
		$this->fld_is_active->setDbValue($rs->fields('fld_is_active'));
		$this->fld_is_blocked->setDbValue($rs->fields('fld_is_blocked'));
		$this->fld_created_on->setDbValue($rs->fields('fld_created_on'));
		$this->fld_total_point->setDbValue($rs->fields('fld_total_point'));
		$this->fld_referal_code->setDbValue($rs->fields('fld_referal_code'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->fld_customer_ai_id->DbValue = $row['fld_customer_ai_id'];
		$this->fld_email->DbValue = $row['fld_email'];
		$this->fld_name->DbValue = $row['fld_name'];
		$this->fld_mobile_no->DbValue = $row['fld_mobile_no'];
		$this->fld_password->DbValue = $row['fld_password'];
		$this->fld_rating->DbValue = $row['fld_rating'];
		$this->fld_user_token->DbValue = $row['fld_user_token'];
		$this->fld_device_id->DbValue = $row['fld_device_id'];
		$this->fld_gcm_regid->DbValue = $row['fld_gcm_regid'];
		$this->fld_is_active->DbValue = $row['fld_is_active'];
		$this->fld_is_blocked->DbValue = $row['fld_is_blocked'];
		$this->fld_created_on->DbValue = $row['fld_created_on'];
		$this->fld_total_point->DbValue = $row['fld_total_point'];
		$this->fld_referal_code->DbValue = $row['fld_referal_code'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->fld_rating->FormValue == $this->fld_rating->CurrentValue && is_numeric(ew_StrToFloat($this->fld_rating->CurrentValue)))
			$this->fld_rating->CurrentValue = ew_StrToFloat($this->fld_rating->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// fld_customer_ai_id
		// fld_email
		// fld_name
		// fld_mobile_no
		// fld_password
		// fld_rating
		// fld_user_token

		$this->fld_user_token->CellCssStyle = "white-space: nowrap;";

		// fld_device_id
		$this->fld_device_id->CellCssStyle = "white-space: nowrap;";

		// fld_gcm_regid
		$this->fld_gcm_regid->CellCssStyle = "white-space: nowrap;";

		// fld_is_active
		// fld_is_blocked
		// fld_created_on
		// fld_total_point
		// fld_referal_code

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// fld_customer_ai_id
			$this->fld_customer_ai_id->ViewValue = $this->fld_customer_ai_id->CurrentValue;
			$this->fld_customer_ai_id->ViewCustomAttributes = "";

			// fld_email
			$this->fld_email->ViewValue = $this->fld_email->CurrentValue;
			$this->fld_email->ViewCustomAttributes = "";

			// fld_name
			$this->fld_name->ViewValue = $this->fld_name->CurrentValue;
			$this->fld_name->ViewCustomAttributes = "";

			// fld_mobile_no
			$this->fld_mobile_no->ViewValue = $this->fld_mobile_no->CurrentValue;
			$this->fld_mobile_no->ViewCustomAttributes = "";

			// fld_password
			$this->fld_password->ViewValue = $this->fld_password->CurrentValue;
			$this->fld_password->ViewCustomAttributes = "";

			// fld_rating
			$this->fld_rating->ViewValue = $this->fld_rating->CurrentValue;
			$this->fld_rating->ViewCustomAttributes = "";

			// fld_is_active
			if (ew_ConvertToBool($this->fld_is_active->CurrentValue)) {
				$this->fld_is_active->ViewValue = $this->fld_is_active->FldTagCaption(1) <> "" ? $this->fld_is_active->FldTagCaption(1) : "1";
			} else {
				$this->fld_is_active->ViewValue = $this->fld_is_active->FldTagCaption(2) <> "" ? $this->fld_is_active->FldTagCaption(2) : "0";
			}
			$this->fld_is_active->ViewCustomAttributes = "";

			// fld_is_blocked
			if (ew_ConvertToBool($this->fld_is_blocked->CurrentValue)) {
				$this->fld_is_blocked->ViewValue = $this->fld_is_blocked->FldTagCaption(1) <> "" ? $this->fld_is_blocked->FldTagCaption(1) : "1";
			} else {
				$this->fld_is_blocked->ViewValue = $this->fld_is_blocked->FldTagCaption(2) <> "" ? $this->fld_is_blocked->FldTagCaption(2) : "0";
			}
			$this->fld_is_blocked->ViewCustomAttributes = "";

			// fld_created_on
			$this->fld_created_on->ViewValue = $this->fld_created_on->CurrentValue;
			$this->fld_created_on->ViewValue = ew_FormatDateTime($this->fld_created_on->ViewValue, 9);
			$this->fld_created_on->ViewCustomAttributes = "";

			// fld_total_point
			$this->fld_total_point->ViewValue = $this->fld_total_point->CurrentValue;
			$this->fld_total_point->ViewCustomAttributes = "";

			// fld_referal_code
			$this->fld_referal_code->ViewValue = $this->fld_referal_code->CurrentValue;
			$this->fld_referal_code->ViewCustomAttributes = "";

			// fld_customer_ai_id
			$this->fld_customer_ai_id->LinkCustomAttributes = "";
			$this->fld_customer_ai_id->HrefValue = "";
			$this->fld_customer_ai_id->TooltipValue = "";

			// fld_email
			$this->fld_email->LinkCustomAttributes = "";
			$this->fld_email->HrefValue = "";
			$this->fld_email->TooltipValue = "";

			// fld_name
			$this->fld_name->LinkCustomAttributes = "";
			$this->fld_name->HrefValue = "";
			$this->fld_name->TooltipValue = "";

			// fld_mobile_no
			$this->fld_mobile_no->LinkCustomAttributes = "";
			$this->fld_mobile_no->HrefValue = "";
			$this->fld_mobile_no->TooltipValue = "";

			// fld_password
			$this->fld_password->LinkCustomAttributes = "";
			$this->fld_password->HrefValue = "";
			$this->fld_password->TooltipValue = "";

			// fld_rating
			$this->fld_rating->LinkCustomAttributes = "";
			$this->fld_rating->HrefValue = "";
			$this->fld_rating->TooltipValue = "";

			// fld_is_active
			$this->fld_is_active->LinkCustomAttributes = "";
			$this->fld_is_active->HrefValue = "";
			$this->fld_is_active->TooltipValue = "";

			// fld_is_blocked
			$this->fld_is_blocked->LinkCustomAttributes = "";
			$this->fld_is_blocked->HrefValue = "";
			$this->fld_is_blocked->TooltipValue = "";

			// fld_created_on
			$this->fld_created_on->LinkCustomAttributes = "";
			$this->fld_created_on->HrefValue = "";
			$this->fld_created_on->TooltipValue = "";

			// fld_total_point
			$this->fld_total_point->LinkCustomAttributes = "";
			$this->fld_total_point->HrefValue = "";
			$this->fld_total_point->TooltipValue = "";

			// fld_referal_code
			$this->fld_referal_code->LinkCustomAttributes = "";
			$this->fld_referal_code->HrefValue = "";
			$this->fld_referal_code->TooltipValue = "";
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
				$sThisKey .= $row['fld_customer_ai_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, "tbl_customer_infolist.php", $this->TableVar, TRUE);
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
if (!isset($tbl_customer_info_delete)) $tbl_customer_info_delete = new ctbl_customer_info_delete();

// Page init
$tbl_customer_info_delete->Page_Init();

// Page main
$tbl_customer_info_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_customer_info_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_customer_info_delete = new ew_Page("tbl_customer_info_delete");
tbl_customer_info_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = tbl_customer_info_delete.PageID; // For backward compatibility

// Form object
var ftbl_customer_infodelete = new ew_Form("ftbl_customer_infodelete");

// Form_CustomValidate event
ftbl_customer_infodelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_customer_infodelete.ValidateRequired = true;
<?php } else { ?>
ftbl_customer_infodelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($tbl_customer_info_delete->Recordset = $tbl_customer_info_delete->LoadRecordset())
	$tbl_customer_info_deleteTotalRecs = $tbl_customer_info_delete->Recordset->RecordCount(); // Get record count
if ($tbl_customer_info_deleteTotalRecs <= 0) { // No record found, exit
	if ($tbl_customer_info_delete->Recordset)
		$tbl_customer_info_delete->Recordset->Close();
	$tbl_customer_info_delete->Page_Terminate("tbl_customer_infolist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_customer_info_delete->ShowPageHeader(); ?>
<?php
$tbl_customer_info_delete->ShowMessage();
?>
<form name="ftbl_customer_infodelete" id="ftbl_customer_infodelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_customer_info">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tbl_customer_info_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_customer_infodelete" class="ewTable ewTableSeparate">
<?php echo $tbl_customer_info->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($tbl_customer_info->fld_customer_ai_id->Visible) { // fld_customer_ai_id ?>
		<td><span id="elh_tbl_customer_info_fld_customer_ai_id" class="tbl_customer_info_fld_customer_ai_id"><?php echo $tbl_customer_info->fld_customer_ai_id->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_customer_info->fld_email->Visible) { // fld_email ?>
		<td><span id="elh_tbl_customer_info_fld_email" class="tbl_customer_info_fld_email"><?php echo $tbl_customer_info->fld_email->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_customer_info->fld_name->Visible) { // fld_name ?>
		<td><span id="elh_tbl_customer_info_fld_name" class="tbl_customer_info_fld_name"><?php echo $tbl_customer_info->fld_name->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_customer_info->fld_mobile_no->Visible) { // fld_mobile_no ?>
		<td><span id="elh_tbl_customer_info_fld_mobile_no" class="tbl_customer_info_fld_mobile_no"><?php echo $tbl_customer_info->fld_mobile_no->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_customer_info->fld_password->Visible) { // fld_password ?>
		<td><span id="elh_tbl_customer_info_fld_password" class="tbl_customer_info_fld_password"><?php echo $tbl_customer_info->fld_password->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_customer_info->fld_rating->Visible) { // fld_rating ?>
		<td><span id="elh_tbl_customer_info_fld_rating" class="tbl_customer_info_fld_rating"><?php echo $tbl_customer_info->fld_rating->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_customer_info->fld_is_active->Visible) { // fld_is_active ?>
		<td><span id="elh_tbl_customer_info_fld_is_active" class="tbl_customer_info_fld_is_active"><?php echo $tbl_customer_info->fld_is_active->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_customer_info->fld_is_blocked->Visible) { // fld_is_blocked ?>
		<td><span id="elh_tbl_customer_info_fld_is_blocked" class="tbl_customer_info_fld_is_blocked"><?php echo $tbl_customer_info->fld_is_blocked->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_customer_info->fld_created_on->Visible) { // fld_created_on ?>
		<td><span id="elh_tbl_customer_info_fld_created_on" class="tbl_customer_info_fld_created_on"><?php echo $tbl_customer_info->fld_created_on->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_customer_info->fld_total_point->Visible) { // fld_total_point ?>
		<td><span id="elh_tbl_customer_info_fld_total_point" class="tbl_customer_info_fld_total_point"><?php echo $tbl_customer_info->fld_total_point->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_customer_info->fld_referal_code->Visible) { // fld_referal_code ?>
		<td><span id="elh_tbl_customer_info_fld_referal_code" class="tbl_customer_info_fld_referal_code"><?php echo $tbl_customer_info->fld_referal_code->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tbl_customer_info_delete->RecCnt = 0;
$i = 0;
while (!$tbl_customer_info_delete->Recordset->EOF) {
	$tbl_customer_info_delete->RecCnt++;
	$tbl_customer_info_delete->RowCnt++;

	// Set row properties
	$tbl_customer_info->ResetAttrs();
	$tbl_customer_info->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tbl_customer_info_delete->LoadRowValues($tbl_customer_info_delete->Recordset);

	// Render row
	$tbl_customer_info_delete->RenderRow();
?>
	<tr<?php echo $tbl_customer_info->RowAttributes() ?>>
<?php if ($tbl_customer_info->fld_customer_ai_id->Visible) { // fld_customer_ai_id ?>
		<td<?php echo $tbl_customer_info->fld_customer_ai_id->CellAttributes() ?>>
<span id="el<?php echo $tbl_customer_info_delete->RowCnt ?>_tbl_customer_info_fld_customer_ai_id" class="control-group tbl_customer_info_fld_customer_ai_id">
<span<?php echo $tbl_customer_info->fld_customer_ai_id->ViewAttributes() ?>>
<?php echo $tbl_customer_info->fld_customer_ai_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_customer_info->fld_email->Visible) { // fld_email ?>
		<td<?php echo $tbl_customer_info->fld_email->CellAttributes() ?>>
<span id="el<?php echo $tbl_customer_info_delete->RowCnt ?>_tbl_customer_info_fld_email" class="control-group tbl_customer_info_fld_email">
<span<?php echo $tbl_customer_info->fld_email->ViewAttributes() ?>>
<?php echo $tbl_customer_info->fld_email->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_customer_info->fld_name->Visible) { // fld_name ?>
		<td<?php echo $tbl_customer_info->fld_name->CellAttributes() ?>>
<span id="el<?php echo $tbl_customer_info_delete->RowCnt ?>_tbl_customer_info_fld_name" class="control-group tbl_customer_info_fld_name">
<span<?php echo $tbl_customer_info->fld_name->ViewAttributes() ?>>
<?php echo $tbl_customer_info->fld_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_customer_info->fld_mobile_no->Visible) { // fld_mobile_no ?>
		<td<?php echo $tbl_customer_info->fld_mobile_no->CellAttributes() ?>>
<span id="el<?php echo $tbl_customer_info_delete->RowCnt ?>_tbl_customer_info_fld_mobile_no" class="control-group tbl_customer_info_fld_mobile_no">
<span<?php echo $tbl_customer_info->fld_mobile_no->ViewAttributes() ?>>
<?php echo $tbl_customer_info->fld_mobile_no->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_customer_info->fld_password->Visible) { // fld_password ?>
		<td<?php echo $tbl_customer_info->fld_password->CellAttributes() ?>>
<span id="el<?php echo $tbl_customer_info_delete->RowCnt ?>_tbl_customer_info_fld_password" class="control-group tbl_customer_info_fld_password">
<span<?php echo $tbl_customer_info->fld_password->ViewAttributes() ?>>
<?php echo $tbl_customer_info->fld_password->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_customer_info->fld_rating->Visible) { // fld_rating ?>
		<td<?php echo $tbl_customer_info->fld_rating->CellAttributes() ?>>
<span id="el<?php echo $tbl_customer_info_delete->RowCnt ?>_tbl_customer_info_fld_rating" class="control-group tbl_customer_info_fld_rating">
<span<?php echo $tbl_customer_info->fld_rating->ViewAttributes() ?>>
<?php echo $tbl_customer_info->fld_rating->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_customer_info->fld_is_active->Visible) { // fld_is_active ?>
		<td<?php echo $tbl_customer_info->fld_is_active->CellAttributes() ?>>
<span id="el<?php echo $tbl_customer_info_delete->RowCnt ?>_tbl_customer_info_fld_is_active" class="control-group tbl_customer_info_fld_is_active">
<span<?php echo $tbl_customer_info->fld_is_active->ViewAttributes() ?>>
<?php echo $tbl_customer_info->fld_is_active->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_customer_info->fld_is_blocked->Visible) { // fld_is_blocked ?>
		<td<?php echo $tbl_customer_info->fld_is_blocked->CellAttributes() ?>>
<span id="el<?php echo $tbl_customer_info_delete->RowCnt ?>_tbl_customer_info_fld_is_blocked" class="control-group tbl_customer_info_fld_is_blocked">
<span<?php echo $tbl_customer_info->fld_is_blocked->ViewAttributes() ?>>
<?php echo $tbl_customer_info->fld_is_blocked->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_customer_info->fld_created_on->Visible) { // fld_created_on ?>
		<td<?php echo $tbl_customer_info->fld_created_on->CellAttributes() ?>>
<span id="el<?php echo $tbl_customer_info_delete->RowCnt ?>_tbl_customer_info_fld_created_on" class="control-group tbl_customer_info_fld_created_on">
<span<?php echo $tbl_customer_info->fld_created_on->ViewAttributes() ?>>
<?php echo $tbl_customer_info->fld_created_on->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_customer_info->fld_total_point->Visible) { // fld_total_point ?>
		<td<?php echo $tbl_customer_info->fld_total_point->CellAttributes() ?>>
<span id="el<?php echo $tbl_customer_info_delete->RowCnt ?>_tbl_customer_info_fld_total_point" class="control-group tbl_customer_info_fld_total_point">
<span<?php echo $tbl_customer_info->fld_total_point->ViewAttributes() ?>>
<?php echo $tbl_customer_info->fld_total_point->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_customer_info->fld_referal_code->Visible) { // fld_referal_code ?>
		<td<?php echo $tbl_customer_info->fld_referal_code->CellAttributes() ?>>
<span id="el<?php echo $tbl_customer_info_delete->RowCnt ?>_tbl_customer_info_fld_referal_code" class="control-group tbl_customer_info_fld_referal_code">
<span<?php echo $tbl_customer_info->fld_referal_code->ViewAttributes() ?>>
<?php echo $tbl_customer_info->fld_referal_code->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tbl_customer_info_delete->Recordset->MoveNext();
}
$tbl_customer_info_delete->Recordset->Close();
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
ftbl_customer_infodelete.Init();
</script>
<?php
$tbl_customer_info_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_customer_info_delete->Page_Terminate();
?>
