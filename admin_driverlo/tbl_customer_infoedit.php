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

$tbl_customer_info_edit = NULL; // Initialize page object first

class ctbl_customer_info_edit extends ctbl_customer_info {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}";

	// Table name
	var $TableName = 'tbl_customer_info';

	// Page object name
	var $PageObjName = 'tbl_customer_info_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("tbl_customer_infolist.php");
		}

		// Create form object
		$objForm = new cFormObj();
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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["fld_customer_ai_id"] <> "") {
			$this->fld_customer_ai_id->setQueryStringValue($_GET["fld_customer_ai_id"]);
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
		if ($this->fld_customer_ai_id->CurrentValue == "")
			$this->Page_Terminate("tbl_customer_infolist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("tbl_customer_infolist.php"); // No matching record, return to list
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
		if (!$this->fld_customer_ai_id->FldIsDetailKey)
			$this->fld_customer_ai_id->setFormValue($objForm->GetValue("x_fld_customer_ai_id"));
		if (!$this->fld_email->FldIsDetailKey) {
			$this->fld_email->setFormValue($objForm->GetValue("x_fld_email"));
		}
		if (!$this->fld_name->FldIsDetailKey) {
			$this->fld_name->setFormValue($objForm->GetValue("x_fld_name"));
		}
		if (!$this->fld_mobile_no->FldIsDetailKey) {
			$this->fld_mobile_no->setFormValue($objForm->GetValue("x_fld_mobile_no"));
		}
		if (!$this->fld_password->FldIsDetailKey) {
			$this->fld_password->setFormValue($objForm->GetValue("x_fld_password"));
		}
		if (!$this->fld_rating->FldIsDetailKey) {
			$this->fld_rating->setFormValue($objForm->GetValue("x_fld_rating"));
		}
		if (!$this->fld_is_active->FldIsDetailKey) {
			$this->fld_is_active->setFormValue($objForm->GetValue("x_fld_is_active"));
		}
		if (!$this->fld_is_blocked->FldIsDetailKey) {
			$this->fld_is_blocked->setFormValue($objForm->GetValue("x_fld_is_blocked"));
		}
		if (!$this->fld_created_on->FldIsDetailKey) {
			$this->fld_created_on->setFormValue($objForm->GetValue("x_fld_created_on"));
			$this->fld_created_on->CurrentValue = ew_UnFormatDateTime($this->fld_created_on->CurrentValue, 9);
		}
		if (!$this->fld_total_point->FldIsDetailKey) {
			$this->fld_total_point->setFormValue($objForm->GetValue("x_fld_total_point"));
		}
		if (!$this->fld_referal_code->FldIsDetailKey) {
			$this->fld_referal_code->setFormValue($objForm->GetValue("x_fld_referal_code"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->fld_customer_ai_id->CurrentValue = $this->fld_customer_ai_id->FormValue;
		$this->fld_email->CurrentValue = $this->fld_email->FormValue;
		$this->fld_name->CurrentValue = $this->fld_name->FormValue;
		$this->fld_mobile_no->CurrentValue = $this->fld_mobile_no->FormValue;
		$this->fld_password->CurrentValue = $this->fld_password->FormValue;
		$this->fld_rating->CurrentValue = $this->fld_rating->FormValue;
		$this->fld_is_active->CurrentValue = $this->fld_is_active->FormValue;
		$this->fld_is_blocked->CurrentValue = $this->fld_is_blocked->FormValue;
		$this->fld_created_on->CurrentValue = $this->fld_created_on->FormValue;
		$this->fld_created_on->CurrentValue = ew_UnFormatDateTime($this->fld_created_on->CurrentValue, 9);
		$this->fld_total_point->CurrentValue = $this->fld_total_point->FormValue;
		$this->fld_referal_code->CurrentValue = $this->fld_referal_code->FormValue;
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
		// fld_device_id
		// fld_gcm_regid
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// fld_customer_ai_id
			$this->fld_customer_ai_id->EditCustomAttributes = "";
			$this->fld_customer_ai_id->EditValue = $this->fld_customer_ai_id->CurrentValue;
			$this->fld_customer_ai_id->ViewCustomAttributes = "";

			// fld_email
			$this->fld_email->EditCustomAttributes = "";
			$this->fld_email->EditValue = ew_HtmlEncode($this->fld_email->CurrentValue);
			$this->fld_email->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_email->FldCaption()));

			// fld_name
			$this->fld_name->EditCustomAttributes = "";
			$this->fld_name->EditValue = ew_HtmlEncode($this->fld_name->CurrentValue);
			$this->fld_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_name->FldCaption()));

			// fld_mobile_no
			$this->fld_mobile_no->EditCustomAttributes = "";
			$this->fld_mobile_no->EditValue = ew_HtmlEncode($this->fld_mobile_no->CurrentValue);
			$this->fld_mobile_no->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_mobile_no->FldCaption()));

			// fld_password
			$this->fld_password->EditCustomAttributes = "";
			$this->fld_password->EditValue = ew_HtmlEncode($this->fld_password->CurrentValue);
			$this->fld_password->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_password->FldCaption()));

			// fld_rating
			$this->fld_rating->EditCustomAttributes = "";
			$this->fld_rating->EditValue = ew_HtmlEncode($this->fld_rating->CurrentValue);
			$this->fld_rating->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_rating->FldCaption()));
			if (strval($this->fld_rating->EditValue) <> "" && is_numeric($this->fld_rating->EditValue)) $this->fld_rating->EditValue = ew_FormatNumber($this->fld_rating->EditValue, -2, -1, -2, 0);

			// fld_is_active
			$this->fld_is_active->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_active->FldTagValue(1), $this->fld_is_active->FldTagCaption(1) <> "" ? $this->fld_is_active->FldTagCaption(1) : $this->fld_is_active->FldTagValue(1));
			$arwrk[] = array($this->fld_is_active->FldTagValue(2), $this->fld_is_active->FldTagCaption(2) <> "" ? $this->fld_is_active->FldTagCaption(2) : $this->fld_is_active->FldTagValue(2));
			$this->fld_is_active->EditValue = $arwrk;

			// fld_is_blocked
			$this->fld_is_blocked->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_blocked->FldTagValue(1), $this->fld_is_blocked->FldTagCaption(1) <> "" ? $this->fld_is_blocked->FldTagCaption(1) : $this->fld_is_blocked->FldTagValue(1));
			$arwrk[] = array($this->fld_is_blocked->FldTagValue(2), $this->fld_is_blocked->FldTagCaption(2) <> "" ? $this->fld_is_blocked->FldTagCaption(2) : $this->fld_is_blocked->FldTagValue(2));
			$this->fld_is_blocked->EditValue = $arwrk;

			// fld_created_on
			$this->fld_created_on->EditCustomAttributes = "";
			$this->fld_created_on->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fld_created_on->CurrentValue, 9));
			$this->fld_created_on->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_created_on->FldCaption()));

			// fld_total_point
			$this->fld_total_point->EditCustomAttributes = "";
			$this->fld_total_point->EditValue = ew_HtmlEncode($this->fld_total_point->CurrentValue);
			$this->fld_total_point->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_total_point->FldCaption()));

			// fld_referal_code
			$this->fld_referal_code->EditCustomAttributes = "";
			$this->fld_referal_code->EditValue = ew_HtmlEncode($this->fld_referal_code->CurrentValue);
			$this->fld_referal_code->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_referal_code->FldCaption()));

			// Edit refer script
			// fld_customer_ai_id

			$this->fld_customer_ai_id->HrefValue = "";

			// fld_email
			$this->fld_email->HrefValue = "";

			// fld_name
			$this->fld_name->HrefValue = "";

			// fld_mobile_no
			$this->fld_mobile_no->HrefValue = "";

			// fld_password
			$this->fld_password->HrefValue = "";

			// fld_rating
			$this->fld_rating->HrefValue = "";

			// fld_is_active
			$this->fld_is_active->HrefValue = "";

			// fld_is_blocked
			$this->fld_is_blocked->HrefValue = "";

			// fld_created_on
			$this->fld_created_on->HrefValue = "";

			// fld_total_point
			$this->fld_total_point->HrefValue = "";

			// fld_referal_code
			$this->fld_referal_code->HrefValue = "";
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
		if (!$this->fld_email->FldIsDetailKey && !is_null($this->fld_email->FormValue) && $this->fld_email->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_email->FldCaption());
		}
		if (!$this->fld_name->FldIsDetailKey && !is_null($this->fld_name->FormValue) && $this->fld_name->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_name->FldCaption());
		}
		if (!$this->fld_mobile_no->FldIsDetailKey && !is_null($this->fld_mobile_no->FormValue) && $this->fld_mobile_no->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_mobile_no->FldCaption());
		}
		if (!$this->fld_password->FldIsDetailKey && !is_null($this->fld_password->FormValue) && $this->fld_password->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_password->FldCaption());
		}
		if (!$this->fld_rating->FldIsDetailKey && !is_null($this->fld_rating->FormValue) && $this->fld_rating->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_rating->FldCaption());
		}
		if (!ew_CheckNumber($this->fld_rating->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_rating->FldErrMsg());
		}
		if ($this->fld_is_active->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_is_active->FldCaption());
		}
		if ($this->fld_is_blocked->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_is_blocked->FldCaption());
		}
		if (!$this->fld_created_on->FldIsDetailKey && !is_null($this->fld_created_on->FormValue) && $this->fld_created_on->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_created_on->FldCaption());
		}
		if (!ew_CheckDate($this->fld_created_on->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_created_on->FldErrMsg());
		}
		if (!ew_CheckInteger($this->fld_total_point->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_total_point->FldErrMsg());
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
		if ($this->fld_mobile_no->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`fld_mobile_no` = '" . ew_AdjustSql($this->fld_mobile_no->CurrentValue) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->fld_mobile_no->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->fld_mobile_no->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
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

			// fld_email
			$this->fld_email->SetDbValueDef($rsnew, $this->fld_email->CurrentValue, NULL, $this->fld_email->ReadOnly);

			// fld_name
			$this->fld_name->SetDbValueDef($rsnew, $this->fld_name->CurrentValue, NULL, $this->fld_name->ReadOnly);

			// fld_mobile_no
			$this->fld_mobile_no->SetDbValueDef($rsnew, $this->fld_mobile_no->CurrentValue, NULL, $this->fld_mobile_no->ReadOnly);

			// fld_password
			$this->fld_password->SetDbValueDef($rsnew, $this->fld_password->CurrentValue, NULL, $this->fld_password->ReadOnly);

			// fld_rating
			$this->fld_rating->SetDbValueDef($rsnew, $this->fld_rating->CurrentValue, NULL, $this->fld_rating->ReadOnly);

			// fld_is_active
			$this->fld_is_active->SetDbValueDef($rsnew, ((strval($this->fld_is_active->CurrentValue) == "1") ? "1" : "0"), NULL, $this->fld_is_active->ReadOnly);

			// fld_is_blocked
			$this->fld_is_blocked->SetDbValueDef($rsnew, ((strval($this->fld_is_blocked->CurrentValue) == "1") ? "1" : "0"), NULL, $this->fld_is_blocked->ReadOnly);

			// fld_created_on
			$this->fld_created_on->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fld_created_on->CurrentValue, 9), NULL, $this->fld_created_on->ReadOnly);

			// fld_total_point
			$this->fld_total_point->SetDbValueDef($rsnew, $this->fld_total_point->CurrentValue, NULL, $this->fld_total_point->ReadOnly);

			// fld_referal_code
			$this->fld_referal_code->SetDbValueDef($rsnew, $this->fld_referal_code->CurrentValue, NULL, $this->fld_referal_code->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, "tbl_customer_infolist.php", $this->TableVar, TRUE);
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
if (!isset($tbl_customer_info_edit)) $tbl_customer_info_edit = new ctbl_customer_info_edit();

// Page init
$tbl_customer_info_edit->Page_Init();

// Page main
$tbl_customer_info_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_customer_info_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_customer_info_edit = new ew_Page("tbl_customer_info_edit");
tbl_customer_info_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = tbl_customer_info_edit.PageID; // For backward compatibility

// Form object
var ftbl_customer_infoedit = new ew_Form("ftbl_customer_infoedit");

// Validate form
ftbl_customer_infoedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_fld_email");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_customer_info->fld_email->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_name");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_customer_info->fld_name->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_mobile_no");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_customer_info->fld_mobile_no->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_password");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_customer_info->fld_password->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_rating");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_customer_info->fld_rating->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_rating");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_customer_info->fld_rating->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_is_active");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_customer_info->fld_is_active->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_is_blocked");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_customer_info->fld_is_blocked->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_created_on");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_customer_info->fld_created_on->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_created_on");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_customer_info->fld_created_on->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_total_point");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_customer_info->fld_total_point->FldErrMsg()) ?>");

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
ftbl_customer_infoedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_customer_infoedit.ValidateRequired = true;
<?php } else { ?>
ftbl_customer_infoedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_customer_info_edit->ShowPageHeader(); ?>
<?php
$tbl_customer_info_edit->ShowMessage();
?>
<form name="ftbl_customer_infoedit" id="ftbl_customer_infoedit" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_customer_info">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table class="ewGrid"><tr><td>
<table id="tbl_tbl_customer_infoedit" class="table table-bordered table-striped">
<?php if ($tbl_customer_info->fld_customer_ai_id->Visible) { // fld_customer_ai_id ?>
	<tr id="r_fld_customer_ai_id">
		<td><span id="elh_tbl_customer_info_fld_customer_ai_id"><?php echo $tbl_customer_info->fld_customer_ai_id->FldCaption() ?></span></td>
		<td<?php echo $tbl_customer_info->fld_customer_ai_id->CellAttributes() ?>>
<span id="el_tbl_customer_info_fld_customer_ai_id" class="control-group">
<span<?php echo $tbl_customer_info->fld_customer_ai_id->ViewAttributes() ?>>
<?php echo $tbl_customer_info->fld_customer_ai_id->EditValue ?></span>
</span>
<input type="hidden" data-field="x_fld_customer_ai_id" name="x_fld_customer_ai_id" id="x_fld_customer_ai_id" value="<?php echo ew_HtmlEncode($tbl_customer_info->fld_customer_ai_id->CurrentValue) ?>">
<?php echo $tbl_customer_info->fld_customer_ai_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_customer_info->fld_email->Visible) { // fld_email ?>
	<tr id="r_fld_email">
		<td><span id="elh_tbl_customer_info_fld_email"><?php echo $tbl_customer_info->fld_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_customer_info->fld_email->CellAttributes() ?>>
<span id="el_tbl_customer_info_fld_email" class="control-group">
<input type="text" data-field="x_fld_email" name="x_fld_email" id="x_fld_email" size="30" maxlength="100" placeholder="<?php echo $tbl_customer_info->fld_email->PlaceHolder ?>" value="<?php echo $tbl_customer_info->fld_email->EditValue ?>"<?php echo $tbl_customer_info->fld_email->EditAttributes() ?>>
</span>
<?php echo $tbl_customer_info->fld_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_customer_info->fld_name->Visible) { // fld_name ?>
	<tr id="r_fld_name">
		<td><span id="elh_tbl_customer_info_fld_name"><?php echo $tbl_customer_info->fld_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_customer_info->fld_name->CellAttributes() ?>>
<span id="el_tbl_customer_info_fld_name" class="control-group">
<input type="text" data-field="x_fld_name" name="x_fld_name" id="x_fld_name" size="30" maxlength="50" placeholder="<?php echo $tbl_customer_info->fld_name->PlaceHolder ?>" value="<?php echo $tbl_customer_info->fld_name->EditValue ?>"<?php echo $tbl_customer_info->fld_name->EditAttributes() ?>>
</span>
<?php echo $tbl_customer_info->fld_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_customer_info->fld_mobile_no->Visible) { // fld_mobile_no ?>
	<tr id="r_fld_mobile_no">
		<td><span id="elh_tbl_customer_info_fld_mobile_no"><?php echo $tbl_customer_info->fld_mobile_no->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_customer_info->fld_mobile_no->CellAttributes() ?>>
<span id="el_tbl_customer_info_fld_mobile_no" class="control-group">
<input type="text" data-field="x_fld_mobile_no" name="x_fld_mobile_no" id="x_fld_mobile_no" size="30" maxlength="20" placeholder="<?php echo $tbl_customer_info->fld_mobile_no->PlaceHolder ?>" value="<?php echo $tbl_customer_info->fld_mobile_no->EditValue ?>"<?php echo $tbl_customer_info->fld_mobile_no->EditAttributes() ?>>
</span>
<?php echo $tbl_customer_info->fld_mobile_no->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_customer_info->fld_password->Visible) { // fld_password ?>
	<tr id="r_fld_password">
		<td><span id="elh_tbl_customer_info_fld_password"><?php echo $tbl_customer_info->fld_password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_customer_info->fld_password->CellAttributes() ?>>
<span id="el_tbl_customer_info_fld_password" class="control-group">
<input type="text" data-field="x_fld_password" name="x_fld_password" id="x_fld_password" size="30" maxlength="50" placeholder="<?php echo $tbl_customer_info->fld_password->PlaceHolder ?>" value="<?php echo $tbl_customer_info->fld_password->EditValue ?>"<?php echo $tbl_customer_info->fld_password->EditAttributes() ?>>
</span>
<?php echo $tbl_customer_info->fld_password->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_customer_info->fld_rating->Visible) { // fld_rating ?>
	<tr id="r_fld_rating">
		<td><span id="elh_tbl_customer_info_fld_rating"><?php echo $tbl_customer_info->fld_rating->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_customer_info->fld_rating->CellAttributes() ?>>
<span id="el_tbl_customer_info_fld_rating" class="control-group">
<input type="text" data-field="x_fld_rating" name="x_fld_rating" id="x_fld_rating" size="30" placeholder="<?php echo $tbl_customer_info->fld_rating->PlaceHolder ?>" value="<?php echo $tbl_customer_info->fld_rating->EditValue ?>"<?php echo $tbl_customer_info->fld_rating->EditAttributes() ?>>
</span>
<?php echo $tbl_customer_info->fld_rating->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_customer_info->fld_is_active->Visible) { // fld_is_active ?>
	<tr id="r_fld_is_active">
		<td><span id="elh_tbl_customer_info_fld_is_active"><?php echo $tbl_customer_info->fld_is_active->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_customer_info->fld_is_active->CellAttributes() ?>>
<span id="el_tbl_customer_info_fld_is_active" class="control-group">
<div id="tp_x_fld_is_active" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_active" id="x_fld_is_active" value="{value}"<?php echo $tbl_customer_info->fld_is_active->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_active" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_customer_info->fld_is_active->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_customer_info->fld_is_active->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_is_active" name="x_fld_is_active" id="x_fld_is_active_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_customer_info->fld_is_active->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_customer_info->fld_is_active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_customer_info->fld_is_blocked->Visible) { // fld_is_blocked ?>
	<tr id="r_fld_is_blocked">
		<td><span id="elh_tbl_customer_info_fld_is_blocked"><?php echo $tbl_customer_info->fld_is_blocked->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_customer_info->fld_is_blocked->CellAttributes() ?>>
<span id="el_tbl_customer_info_fld_is_blocked" class="control-group">
<div id="tp_x_fld_is_blocked" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_blocked" id="x_fld_is_blocked" value="{value}"<?php echo $tbl_customer_info->fld_is_blocked->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_blocked" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_customer_info->fld_is_blocked->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_customer_info->fld_is_blocked->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_is_blocked" name="x_fld_is_blocked" id="x_fld_is_blocked_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_customer_info->fld_is_blocked->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_customer_info->fld_is_blocked->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_customer_info->fld_created_on->Visible) { // fld_created_on ?>
	<tr id="r_fld_created_on">
		<td><span id="elh_tbl_customer_info_fld_created_on"><?php echo $tbl_customer_info->fld_created_on->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_customer_info->fld_created_on->CellAttributes() ?>>
<span id="el_tbl_customer_info_fld_created_on" class="control-group">
<input type="text" data-field="x_fld_created_on" name="x_fld_created_on" id="x_fld_created_on" placeholder="<?php echo $tbl_customer_info->fld_created_on->PlaceHolder ?>" value="<?php echo $tbl_customer_info->fld_created_on->EditValue ?>"<?php echo $tbl_customer_info->fld_created_on->EditAttributes() ?>>
<?php if (!$tbl_customer_info->fld_created_on->ReadOnly && !$tbl_customer_info->fld_created_on->Disabled && @$tbl_customer_info->fld_created_on->EditAttrs["readonly"] == "" && @$tbl_customer_info->fld_created_on->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_fld_created_on" name="cal_x_fld_created_on" class="btn" type="button"><img src="phpimages/calendar.png" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("ftbl_customer_infoedit", "x_fld_created_on", "%Y/%m/%d %H:%M:%S");
</script>
<?php } ?>
</span>
<?php echo $tbl_customer_info->fld_created_on->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_customer_info->fld_total_point->Visible) { // fld_total_point ?>
	<tr id="r_fld_total_point">
		<td><span id="elh_tbl_customer_info_fld_total_point"><?php echo $tbl_customer_info->fld_total_point->FldCaption() ?></span></td>
		<td<?php echo $tbl_customer_info->fld_total_point->CellAttributes() ?>>
<span id="el_tbl_customer_info_fld_total_point" class="control-group">
<input type="text" data-field="x_fld_total_point" name="x_fld_total_point" id="x_fld_total_point" size="30" placeholder="<?php echo $tbl_customer_info->fld_total_point->PlaceHolder ?>" value="<?php echo $tbl_customer_info->fld_total_point->EditValue ?>"<?php echo $tbl_customer_info->fld_total_point->EditAttributes() ?>>
</span>
<?php echo $tbl_customer_info->fld_total_point->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_customer_info->fld_referal_code->Visible) { // fld_referal_code ?>
	<tr id="r_fld_referal_code">
		<td><span id="elh_tbl_customer_info_fld_referal_code"><?php echo $tbl_customer_info->fld_referal_code->FldCaption() ?></span></td>
		<td<?php echo $tbl_customer_info->fld_referal_code->CellAttributes() ?>>
<span id="el_tbl_customer_info_fld_referal_code" class="control-group">
<input type="text" data-field="x_fld_referal_code" name="x_fld_referal_code" id="x_fld_referal_code" size="30" maxlength="50" placeholder="<?php echo $tbl_customer_info->fld_referal_code->PlaceHolder ?>" value="<?php echo $tbl_customer_info->fld_referal_code->EditValue ?>"<?php echo $tbl_customer_info->fld_referal_code->EditAttributes() ?>>
</span>
<?php echo $tbl_customer_info->fld_referal_code->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("EditBtn") ?></button>
</form>
<script type="text/javascript">
ftbl_customer_infoedit.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_customer_info_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_customer_info_edit->Page_Terminate();
?>
