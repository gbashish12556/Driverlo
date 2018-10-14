<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_coupon_discountinfo.php" ?>
<?php include_once "tbl_admininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$tbl_coupon_discount_delete = NULL; // Initialize page object first

class ctbl_coupon_discount_delete extends ctbl_coupon_discount {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}";

	// Table name
	var $TableName = 'tbl_coupon_discount';

	// Page object name
	var $PageObjName = 'tbl_coupon_discount_delete';

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

		// Table object (tbl_coupon_discount)
		if (!isset($GLOBALS["tbl_coupon_discount"]) || get_class($GLOBALS["tbl_coupon_discount"]) == "ctbl_coupon_discount") {
			$GLOBALS["tbl_coupon_discount"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_coupon_discount"];
		}

		// Table object (tbl_admin)
		if (!isset($GLOBALS['tbl_admin'])) $GLOBALS['tbl_admin'] = new ctbl_admin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_coupon_discount', TRUE);

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
			$this->Page_Terminate("tbl_coupon_discountlist.php");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action
		$this->fld_coupon_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->Page_Terminate("tbl_coupon_discountlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tbl_coupon_discount class, tbl_coupon_discountinfo.php

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
		$this->fld_coupon_id->setDbValue($rs->fields('fld_coupon_id'));
		$this->fld_coupon_code->setDbValue($rs->fields('fld_coupon_code'));
		$this->fld_coupon_discount->setDbValue($rs->fields('fld_coupon_discount'));
		$this->fld_is_validated->setDbValue($rs->fields('fld_is_validated'));
		$this->fld_is_active->setDbValue($rs->fields('fld_is_active'));
		$this->fld_created_on->setDbValue($rs->fields('fld_created_on'));
		$this->fld_is_referal->setDbValue($rs->fields('fld_is_referal'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->fld_coupon_id->DbValue = $row['fld_coupon_id'];
		$this->fld_coupon_code->DbValue = $row['fld_coupon_code'];
		$this->fld_coupon_discount->DbValue = $row['fld_coupon_discount'];
		$this->fld_is_validated->DbValue = $row['fld_is_validated'];
		$this->fld_is_active->DbValue = $row['fld_is_active'];
		$this->fld_created_on->DbValue = $row['fld_created_on'];
		$this->fld_is_referal->DbValue = $row['fld_is_referal'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// fld_coupon_id
		// fld_coupon_code
		// fld_coupon_discount
		// fld_is_validated
		// fld_is_active
		// fld_created_on
		// fld_is_referal

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// fld_coupon_id
			$this->fld_coupon_id->ViewValue = $this->fld_coupon_id->CurrentValue;
			$this->fld_coupon_id->ViewCustomAttributes = "";

			// fld_coupon_code
			$this->fld_coupon_code->ViewValue = $this->fld_coupon_code->CurrentValue;
			$this->fld_coupon_code->ViewCustomAttributes = "";

			// fld_coupon_discount
			$this->fld_coupon_discount->ViewValue = $this->fld_coupon_discount->CurrentValue;
			$this->fld_coupon_discount->ViewCustomAttributes = "";

			// fld_is_validated
			if (ew_ConvertToBool($this->fld_is_validated->CurrentValue)) {
				$this->fld_is_validated->ViewValue = $this->fld_is_validated->FldTagCaption(1) <> "" ? $this->fld_is_validated->FldTagCaption(1) : "1";
			} else {
				$this->fld_is_validated->ViewValue = $this->fld_is_validated->FldTagCaption(2) <> "" ? $this->fld_is_validated->FldTagCaption(2) : "0";
			}
			$this->fld_is_validated->ViewCustomAttributes = "";

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

			// fld_is_referal
			if (ew_ConvertToBool($this->fld_is_referal->CurrentValue)) {
				$this->fld_is_referal->ViewValue = $this->fld_is_referal->FldTagCaption(1) <> "" ? $this->fld_is_referal->FldTagCaption(1) : "1";
			} else {
				$this->fld_is_referal->ViewValue = $this->fld_is_referal->FldTagCaption(2) <> "" ? $this->fld_is_referal->FldTagCaption(2) : "0";
			}
			$this->fld_is_referal->ViewCustomAttributes = "";

			// fld_coupon_id
			$this->fld_coupon_id->LinkCustomAttributes = "";
			$this->fld_coupon_id->HrefValue = "";
			$this->fld_coupon_id->TooltipValue = "";

			// fld_coupon_code
			$this->fld_coupon_code->LinkCustomAttributes = "";
			$this->fld_coupon_code->HrefValue = "";
			$this->fld_coupon_code->TooltipValue = "";

			// fld_coupon_discount
			$this->fld_coupon_discount->LinkCustomAttributes = "";
			$this->fld_coupon_discount->HrefValue = "";
			$this->fld_coupon_discount->TooltipValue = "";

			// fld_is_validated
			$this->fld_is_validated->LinkCustomAttributes = "";
			$this->fld_is_validated->HrefValue = "";
			$this->fld_is_validated->TooltipValue = "";

			// fld_is_active
			$this->fld_is_active->LinkCustomAttributes = "";
			$this->fld_is_active->HrefValue = "";
			$this->fld_is_active->TooltipValue = "";

			// fld_created_on
			$this->fld_created_on->LinkCustomAttributes = "";
			$this->fld_created_on->HrefValue = "";
			$this->fld_created_on->TooltipValue = "";

			// fld_is_referal
			$this->fld_is_referal->LinkCustomAttributes = "";
			$this->fld_is_referal->HrefValue = "";
			$this->fld_is_referal->TooltipValue = "";
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
				$sThisKey .= $row['fld_coupon_id'];
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
		$Breadcrumb->Add("list", $this->TableVar, "tbl_coupon_discountlist.php", $this->TableVar, TRUE);
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
if (!isset($tbl_coupon_discount_delete)) $tbl_coupon_discount_delete = new ctbl_coupon_discount_delete();

// Page init
$tbl_coupon_discount_delete->Page_Init();

// Page main
$tbl_coupon_discount_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_coupon_discount_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_coupon_discount_delete = new ew_Page("tbl_coupon_discount_delete");
tbl_coupon_discount_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = tbl_coupon_discount_delete.PageID; // For backward compatibility

// Form object
var ftbl_coupon_discountdelete = new ew_Form("ftbl_coupon_discountdelete");

// Form_CustomValidate event
ftbl_coupon_discountdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_coupon_discountdelete.ValidateRequired = true;
<?php } else { ?>
ftbl_coupon_discountdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($tbl_coupon_discount_delete->Recordset = $tbl_coupon_discount_delete->LoadRecordset())
	$tbl_coupon_discount_deleteTotalRecs = $tbl_coupon_discount_delete->Recordset->RecordCount(); // Get record count
if ($tbl_coupon_discount_deleteTotalRecs <= 0) { // No record found, exit
	if ($tbl_coupon_discount_delete->Recordset)
		$tbl_coupon_discount_delete->Recordset->Close();
	$tbl_coupon_discount_delete->Page_Terminate("tbl_coupon_discountlist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_coupon_discount_delete->ShowPageHeader(); ?>
<?php
$tbl_coupon_discount_delete->ShowMessage();
?>
<form name="ftbl_coupon_discountdelete" id="ftbl_coupon_discountdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_coupon_discount">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tbl_coupon_discount_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_tbl_coupon_discountdelete" class="ewTable ewTableSeparate">
<?php echo $tbl_coupon_discount->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($tbl_coupon_discount->fld_coupon_id->Visible) { // fld_coupon_id ?>
		<td><span id="elh_tbl_coupon_discount_fld_coupon_id" class="tbl_coupon_discount_fld_coupon_id"><?php echo $tbl_coupon_discount->fld_coupon_id->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_coupon_code->Visible) { // fld_coupon_code ?>
		<td><span id="elh_tbl_coupon_discount_fld_coupon_code" class="tbl_coupon_discount_fld_coupon_code"><?php echo $tbl_coupon_discount->fld_coupon_code->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_coupon_discount->Visible) { // fld_coupon_discount ?>
		<td><span id="elh_tbl_coupon_discount_fld_coupon_discount" class="tbl_coupon_discount_fld_coupon_discount"><?php echo $tbl_coupon_discount->fld_coupon_discount->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_is_validated->Visible) { // fld_is_validated ?>
		<td><span id="elh_tbl_coupon_discount_fld_is_validated" class="tbl_coupon_discount_fld_is_validated"><?php echo $tbl_coupon_discount->fld_is_validated->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_is_active->Visible) { // fld_is_active ?>
		<td><span id="elh_tbl_coupon_discount_fld_is_active" class="tbl_coupon_discount_fld_is_active"><?php echo $tbl_coupon_discount->fld_is_active->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_created_on->Visible) { // fld_created_on ?>
		<td><span id="elh_tbl_coupon_discount_fld_created_on" class="tbl_coupon_discount_fld_created_on"><?php echo $tbl_coupon_discount->fld_created_on->FldCaption() ?></span></td>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_is_referal->Visible) { // fld_is_referal ?>
		<td><span id="elh_tbl_coupon_discount_fld_is_referal" class="tbl_coupon_discount_fld_is_referal"><?php echo $tbl_coupon_discount->fld_is_referal->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tbl_coupon_discount_delete->RecCnt = 0;
$i = 0;
while (!$tbl_coupon_discount_delete->Recordset->EOF) {
	$tbl_coupon_discount_delete->RecCnt++;
	$tbl_coupon_discount_delete->RowCnt++;

	// Set row properties
	$tbl_coupon_discount->ResetAttrs();
	$tbl_coupon_discount->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tbl_coupon_discount_delete->LoadRowValues($tbl_coupon_discount_delete->Recordset);

	// Render row
	$tbl_coupon_discount_delete->RenderRow();
?>
	<tr<?php echo $tbl_coupon_discount->RowAttributes() ?>>
<?php if ($tbl_coupon_discount->fld_coupon_id->Visible) { // fld_coupon_id ?>
		<td<?php echo $tbl_coupon_discount->fld_coupon_id->CellAttributes() ?>>
<span id="el<?php echo $tbl_coupon_discount_delete->RowCnt ?>_tbl_coupon_discount_fld_coupon_id" class="control-group tbl_coupon_discount_fld_coupon_id">
<span<?php echo $tbl_coupon_discount->fld_coupon_id->ViewAttributes() ?>>
<?php echo $tbl_coupon_discount->fld_coupon_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_coupon_code->Visible) { // fld_coupon_code ?>
		<td<?php echo $tbl_coupon_discount->fld_coupon_code->CellAttributes() ?>>
<span id="el<?php echo $tbl_coupon_discount_delete->RowCnt ?>_tbl_coupon_discount_fld_coupon_code" class="control-group tbl_coupon_discount_fld_coupon_code">
<span<?php echo $tbl_coupon_discount->fld_coupon_code->ViewAttributes() ?>>
<?php echo $tbl_coupon_discount->fld_coupon_code->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_coupon_discount->Visible) { // fld_coupon_discount ?>
		<td<?php echo $tbl_coupon_discount->fld_coupon_discount->CellAttributes() ?>>
<span id="el<?php echo $tbl_coupon_discount_delete->RowCnt ?>_tbl_coupon_discount_fld_coupon_discount" class="control-group tbl_coupon_discount_fld_coupon_discount">
<span<?php echo $tbl_coupon_discount->fld_coupon_discount->ViewAttributes() ?>>
<?php echo $tbl_coupon_discount->fld_coupon_discount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_is_validated->Visible) { // fld_is_validated ?>
		<td<?php echo $tbl_coupon_discount->fld_is_validated->CellAttributes() ?>>
<span id="el<?php echo $tbl_coupon_discount_delete->RowCnt ?>_tbl_coupon_discount_fld_is_validated" class="control-group tbl_coupon_discount_fld_is_validated">
<span<?php echo $tbl_coupon_discount->fld_is_validated->ViewAttributes() ?>>
<?php echo $tbl_coupon_discount->fld_is_validated->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_is_active->Visible) { // fld_is_active ?>
		<td<?php echo $tbl_coupon_discount->fld_is_active->CellAttributes() ?>>
<span id="el<?php echo $tbl_coupon_discount_delete->RowCnt ?>_tbl_coupon_discount_fld_is_active" class="control-group tbl_coupon_discount_fld_is_active">
<span<?php echo $tbl_coupon_discount->fld_is_active->ViewAttributes() ?>>
<?php echo $tbl_coupon_discount->fld_is_active->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_created_on->Visible) { // fld_created_on ?>
		<td<?php echo $tbl_coupon_discount->fld_created_on->CellAttributes() ?>>
<span id="el<?php echo $tbl_coupon_discount_delete->RowCnt ?>_tbl_coupon_discount_fld_created_on" class="control-group tbl_coupon_discount_fld_created_on">
<span<?php echo $tbl_coupon_discount->fld_created_on->ViewAttributes() ?>>
<?php echo $tbl_coupon_discount->fld_created_on->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_is_referal->Visible) { // fld_is_referal ?>
		<td<?php echo $tbl_coupon_discount->fld_is_referal->CellAttributes() ?>>
<span id="el<?php echo $tbl_coupon_discount_delete->RowCnt ?>_tbl_coupon_discount_fld_is_referal" class="control-group tbl_coupon_discount_fld_is_referal">
<span<?php echo $tbl_coupon_discount->fld_is_referal->ViewAttributes() ?>>
<?php echo $tbl_coupon_discount->fld_is_referal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tbl_coupon_discount_delete->Recordset->MoveNext();
}
$tbl_coupon_discount_delete->Recordset->Close();
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
ftbl_coupon_discountdelete.Init();
</script>
<?php
$tbl_coupon_discount_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_coupon_discount_delete->Page_Terminate();
?>
