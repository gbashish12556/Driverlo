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

$tbl_coupon_discount_edit = NULL; // Initialize page object first

class ctbl_coupon_discount_edit extends ctbl_coupon_discount {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}";

	// Table name
	var $TableName = 'tbl_coupon_discount';

	// Page object name
	var $PageObjName = 'tbl_coupon_discount_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("tbl_coupon_discountlist.php");
		}

		// Create form object
		$objForm = new cFormObj();
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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["fld_coupon_id"] <> "") {
			$this->fld_coupon_id->setQueryStringValue($_GET["fld_coupon_id"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->fld_coupon_id->CurrentValue == "")
			$this->Page_Terminate("tbl_coupon_discountlist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tbl_coupon_discountlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->fld_coupon_id->FldIsDetailKey)
			$this->fld_coupon_id->setFormValue($objForm->GetValue("x_fld_coupon_id"));
		if (!$this->fld_coupon_code->FldIsDetailKey) {
			$this->fld_coupon_code->setFormValue($objForm->GetValue("x_fld_coupon_code"));
		}
		if (!$this->fld_coupon_discount->FldIsDetailKey) {
			$this->fld_coupon_discount->setFormValue($objForm->GetValue("x_fld_coupon_discount"));
		}
		if (!$this->fld_is_validated->FldIsDetailKey) {
			$this->fld_is_validated->setFormValue($objForm->GetValue("x_fld_is_validated"));
		}
		if (!$this->fld_is_active->FldIsDetailKey) {
			$this->fld_is_active->setFormValue($objForm->GetValue("x_fld_is_active"));
		}
		if (!$this->fld_created_on->FldIsDetailKey) {
			$this->fld_created_on->setFormValue($objForm->GetValue("x_fld_created_on"));
			$this->fld_created_on->CurrentValue = ew_UnFormatDateTime($this->fld_created_on->CurrentValue, 9);
		}
		if (!$this->fld_is_referal->FldIsDetailKey) {
			$this->fld_is_referal->setFormValue($objForm->GetValue("x_fld_is_referal"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->fld_coupon_id->CurrentValue = $this->fld_coupon_id->FormValue;
		$this->fld_coupon_code->CurrentValue = $this->fld_coupon_code->FormValue;
		$this->fld_coupon_discount->CurrentValue = $this->fld_coupon_discount->FormValue;
		$this->fld_is_validated->CurrentValue = $this->fld_is_validated->FormValue;
		$this->fld_is_active->CurrentValue = $this->fld_is_active->FormValue;
		$this->fld_created_on->CurrentValue = $this->fld_created_on->FormValue;
		$this->fld_created_on->CurrentValue = ew_UnFormatDateTime($this->fld_created_on->CurrentValue, 9);
		$this->fld_is_referal->CurrentValue = $this->fld_is_referal->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// fld_coupon_id
			$this->fld_coupon_id->EditCustomAttributes = "";
			$this->fld_coupon_id->EditValue = $this->fld_coupon_id->CurrentValue;
			$this->fld_coupon_id->ViewCustomAttributes = "";

			// fld_coupon_code
			$this->fld_coupon_code->EditCustomAttributes = "";
			$this->fld_coupon_code->EditValue = ew_HtmlEncode($this->fld_coupon_code->CurrentValue);
			$this->fld_coupon_code->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_coupon_code->FldCaption()));

			// fld_coupon_discount
			$this->fld_coupon_discount->EditCustomAttributes = "";
			$this->fld_coupon_discount->EditValue = ew_HtmlEncode($this->fld_coupon_discount->CurrentValue);
			$this->fld_coupon_discount->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_coupon_discount->FldCaption()));

			// fld_is_validated
			$this->fld_is_validated->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_validated->FldTagValue(1), $this->fld_is_validated->FldTagCaption(1) <> "" ? $this->fld_is_validated->FldTagCaption(1) : $this->fld_is_validated->FldTagValue(1));
			$arwrk[] = array($this->fld_is_validated->FldTagValue(2), $this->fld_is_validated->FldTagCaption(2) <> "" ? $this->fld_is_validated->FldTagCaption(2) : $this->fld_is_validated->FldTagValue(2));
			$this->fld_is_validated->EditValue = $arwrk;

			// fld_is_active
			$this->fld_is_active->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_active->FldTagValue(1), $this->fld_is_active->FldTagCaption(1) <> "" ? $this->fld_is_active->FldTagCaption(1) : $this->fld_is_active->FldTagValue(1));
			$arwrk[] = array($this->fld_is_active->FldTagValue(2), $this->fld_is_active->FldTagCaption(2) <> "" ? $this->fld_is_active->FldTagCaption(2) : $this->fld_is_active->FldTagValue(2));
			$this->fld_is_active->EditValue = $arwrk;

			// fld_created_on
			$this->fld_created_on->EditCustomAttributes = "";
			$this->fld_created_on->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fld_created_on->CurrentValue, 9));
			$this->fld_created_on->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_created_on->FldCaption()));

			// fld_is_referal
			$this->fld_is_referal->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_referal->FldTagValue(1), $this->fld_is_referal->FldTagCaption(1) <> "" ? $this->fld_is_referal->FldTagCaption(1) : $this->fld_is_referal->FldTagValue(1));
			$arwrk[] = array($this->fld_is_referal->FldTagValue(2), $this->fld_is_referal->FldTagCaption(2) <> "" ? $this->fld_is_referal->FldTagCaption(2) : $this->fld_is_referal->FldTagValue(2));
			$this->fld_is_referal->EditValue = $arwrk;

			// Edit refer script
			// fld_coupon_id

			$this->fld_coupon_id->HrefValue = "";

			// fld_coupon_code
			$this->fld_coupon_code->HrefValue = "";

			// fld_coupon_discount
			$this->fld_coupon_discount->HrefValue = "";

			// fld_is_validated
			$this->fld_is_validated->HrefValue = "";

			// fld_is_active
			$this->fld_is_active->HrefValue = "";

			// fld_created_on
			$this->fld_created_on->HrefValue = "";

			// fld_is_referal
			$this->fld_is_referal->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->fld_coupon_code->FldIsDetailKey && !is_null($this->fld_coupon_code->FormValue) && $this->fld_coupon_code->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_coupon_code->FldCaption());
		}
		if (!$this->fld_coupon_discount->FldIsDetailKey && !is_null($this->fld_coupon_discount->FormValue) && $this->fld_coupon_discount->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_coupon_discount->FldCaption());
		}
		if (!ew_CheckInteger($this->fld_coupon_discount->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_coupon_discount->FldErrMsg());
		}
		if ($this->fld_is_validated->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_is_validated->FldCaption());
		}
		if ($this->fld_is_active->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_is_active->FldCaption());
		}
		if (!$this->fld_created_on->FldIsDetailKey && !is_null($this->fld_created_on->FormValue) && $this->fld_created_on->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_created_on->FldCaption());
		}
		if (!ew_CheckDate($this->fld_created_on->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_created_on->FldErrMsg());
		}
		if ($this->fld_is_referal->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_is_referal->FldCaption());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// fld_coupon_code
			$this->fld_coupon_code->SetDbValueDef($rsnew, $this->fld_coupon_code->CurrentValue, "", $this->fld_coupon_code->ReadOnly);

			// fld_coupon_discount
			$this->fld_coupon_discount->SetDbValueDef($rsnew, $this->fld_coupon_discount->CurrentValue, NULL, $this->fld_coupon_discount->ReadOnly);

			// fld_is_validated
			$this->fld_is_validated->SetDbValueDef($rsnew, ((strval($this->fld_is_validated->CurrentValue) == "1") ? "1" : "0"), NULL, $this->fld_is_validated->ReadOnly);

			// fld_is_active
			$this->fld_is_active->SetDbValueDef($rsnew, ((strval($this->fld_is_active->CurrentValue) == "1") ? "1" : "0"), NULL, $this->fld_is_active->ReadOnly);

			// fld_created_on
			$this->fld_created_on->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fld_created_on->CurrentValue, 9), NULL, $this->fld_created_on->ReadOnly);

			// fld_is_referal
			$this->fld_is_referal->SetDbValueDef($rsnew, ((strval($this->fld_is_referal->CurrentValue) == "1") ? "1" : "0"), NULL, $this->fld_is_referal->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "tbl_coupon_discountlist.php", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, ew_CurrentUrl());
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_coupon_discount_edit)) $tbl_coupon_discount_edit = new ctbl_coupon_discount_edit();

// Page init
$tbl_coupon_discount_edit->Page_Init();

// Page main
$tbl_coupon_discount_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_coupon_discount_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_coupon_discount_edit = new ew_Page("tbl_coupon_discount_edit");
tbl_coupon_discount_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_coupon_discount_edit.PageID; // For backward compatibility

// Form object
var ftbl_coupon_discountedit = new ew_Form("ftbl_coupon_discountedit");

// Validate form
ftbl_coupon_discountedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_fld_coupon_code");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_coupon_discount->fld_coupon_code->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_coupon_discount");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_coupon_discount->fld_coupon_discount->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_coupon_discount");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_coupon_discount->fld_coupon_discount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_is_validated");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_coupon_discount->fld_is_validated->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_is_active");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_coupon_discount->fld_is_active->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_created_on");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_coupon_discount->fld_created_on->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_created_on");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_coupon_discount->fld_created_on->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_is_referal");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_coupon_discount->fld_is_referal->FldCaption()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ftbl_coupon_discountedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_coupon_discountedit.ValidateRequired = true;
<?php } else { ?>
ftbl_coupon_discountedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_coupon_discount_edit->ShowPageHeader(); ?>
<?php
$tbl_coupon_discount_edit->ShowMessage();
?>
<form name="ftbl_coupon_discountedit" id="ftbl_coupon_discountedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_coupon_discount">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewGrid"><tr><td>
<table id="tbl_tbl_coupon_discountedit" class="table table-bordered table-striped">
<?php if ($tbl_coupon_discount->fld_coupon_id->Visible) { // fld_coupon_id ?>
	<tr id="r_fld_coupon_id">
		<td><span id="elh_tbl_coupon_discount_fld_coupon_id"><?php echo $tbl_coupon_discount->fld_coupon_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_coupon_discount->fld_coupon_id->CellAttributes() ?>>
<span id="el_tbl_coupon_discount_fld_coupon_id" class="control-group">
<span<?php echo $tbl_coupon_discount->fld_coupon_id->ViewAttributes() ?>>
<?php echo $tbl_coupon_discount->fld_coupon_id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_fld_coupon_id" name="x_fld_coupon_id" id="x_fld_coupon_id" value="<?php echo ew_HtmlEncode($tbl_coupon_discount->fld_coupon_id->CurrentValue) ?>">
<?php echo $tbl_coupon_discount->fld_coupon_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_coupon_code->Visible) { // fld_coupon_code ?>
	<tr id="r_fld_coupon_code">
		<td><span id="elh_tbl_coupon_discount_fld_coupon_code"><?php echo $tbl_coupon_discount->fld_coupon_code->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_coupon_discount->fld_coupon_code->CellAttributes() ?>>
<span id="el_tbl_coupon_discount_fld_coupon_code" class="control-group">
<input type="text" data-field="x_fld_coupon_code" name="x_fld_coupon_code" id="x_fld_coupon_code" size="30" maxlength="40" placeholder="<?php echo $tbl_coupon_discount->fld_coupon_code->PlaceHolder ?>" value="<?php echo $tbl_coupon_discount->fld_coupon_code->EditValue ?>"<?php echo $tbl_coupon_discount->fld_coupon_code->EditAttributes() ?>>
</span>
<?php echo $tbl_coupon_discount->fld_coupon_code->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_coupon_discount->Visible) { // fld_coupon_discount ?>
	<tr id="r_fld_coupon_discount">
		<td><span id="elh_tbl_coupon_discount_fld_coupon_discount"><?php echo $tbl_coupon_discount->fld_coupon_discount->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_coupon_discount->fld_coupon_discount->CellAttributes() ?>>
<span id="el_tbl_coupon_discount_fld_coupon_discount" class="control-group">
<input type="text" data-field="x_fld_coupon_discount" name="x_fld_coupon_discount" id="x_fld_coupon_discount" size="30" placeholder="<?php echo $tbl_coupon_discount->fld_coupon_discount->PlaceHolder ?>" value="<?php echo $tbl_coupon_discount->fld_coupon_discount->EditValue ?>"<?php echo $tbl_coupon_discount->fld_coupon_discount->EditAttributes() ?>>
</span>
<?php echo $tbl_coupon_discount->fld_coupon_discount->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_is_validated->Visible) { // fld_is_validated ?>
	<tr id="r_fld_is_validated">
		<td><span id="elh_tbl_coupon_discount_fld_is_validated"><?php echo $tbl_coupon_discount->fld_is_validated->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_coupon_discount->fld_is_validated->CellAttributes() ?>>
<span id="el_tbl_coupon_discount_fld_is_validated" class="control-group">
<div id="tp_x_fld_is_validated" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_validated" id="x_fld_is_validated" value="{value}"<?php echo $tbl_coupon_discount->fld_is_validated->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_validated" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_coupon_discount->fld_is_validated->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_coupon_discount->fld_is_validated->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_is_validated" name="x_fld_is_validated" id="x_fld_is_validated_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_coupon_discount->fld_is_validated->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_coupon_discount->fld_is_validated->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_is_active->Visible) { // fld_is_active ?>
	<tr id="r_fld_is_active">
		<td><span id="elh_tbl_coupon_discount_fld_is_active"><?php echo $tbl_coupon_discount->fld_is_active->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_coupon_discount->fld_is_active->CellAttributes() ?>>
<span id="el_tbl_coupon_discount_fld_is_active" class="control-group">
<div id="tp_x_fld_is_active" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_active" id="x_fld_is_active" value="{value}"<?php echo $tbl_coupon_discount->fld_is_active->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_active" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_coupon_discount->fld_is_active->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_coupon_discount->fld_is_active->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_is_active" name="x_fld_is_active" id="x_fld_is_active_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_coupon_discount->fld_is_active->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_coupon_discount->fld_is_active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_created_on->Visible) { // fld_created_on ?>
	<tr id="r_fld_created_on">
		<td><span id="elh_tbl_coupon_discount_fld_created_on"><?php echo $tbl_coupon_discount->fld_created_on->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_coupon_discount->fld_created_on->CellAttributes() ?>>
<span id="el_tbl_coupon_discount_fld_created_on" class="control-group">
<input type="text" data-field="x_fld_created_on" name="x_fld_created_on" id="x_fld_created_on" placeholder="<?php echo $tbl_coupon_discount->fld_created_on->PlaceHolder ?>" value="<?php echo $tbl_coupon_discount->fld_created_on->EditValue ?>"<?php echo $tbl_coupon_discount->fld_created_on->EditAttributes() ?>>
<?php if (!$tbl_coupon_discount->fld_created_on->ReadOnly && !$tbl_coupon_discount->fld_created_on->Disabled && @$tbl_coupon_discount->fld_created_on->EditAttrs["readonly"] == "" && @$tbl_coupon_discount->fld_created_on->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_fld_created_on" name="cal_x_fld_created_on" class="btn" type="button"><img src="phpimages/calendar.png" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_coupon_discountedit", "x_fld_created_on", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php echo $tbl_coupon_discount->fld_created_on->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_coupon_discount->fld_is_referal->Visible) { // fld_is_referal ?>
	<tr id="r_fld_is_referal">
		<td><span id="elh_tbl_coupon_discount_fld_is_referal"><?php echo $tbl_coupon_discount->fld_is_referal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_coupon_discount->fld_is_referal->CellAttributes() ?>>
<span id="el_tbl_coupon_discount_fld_is_referal" class="control-group">
<div id="tp_x_fld_is_referal" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_referal" id="x_fld_is_referal" value="{value}"<?php echo $tbl_coupon_discount->fld_is_referal->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_referal" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_coupon_discount->fld_is_referal->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_coupon_discount->fld_is_referal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_is_referal" name="x_fld_is_referal" id="x_fld_is_referal_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_coupon_discount->fld_is_referal->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_coupon_discount->fld_is_referal->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
ftbl_coupon_discountedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_coupon_discount_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_coupon_discount_edit->Page_Terminate();
?>
