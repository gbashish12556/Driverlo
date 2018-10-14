<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_franchise_infoinfo.php" ?>
<?php include_once "tbl_admininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$tbl_franchise_info_add = NULL; // Initialize page object first

class ctbl_franchise_info_add extends ctbl_franchise_info {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}";

	// Table name
	var $TableName = 'tbl_franchise_info';

	// Page object name
	var $PageObjName = 'tbl_franchise_info_add';

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

		// Table object (tbl_franchise_info)
		if (!isset($GLOBALS["tbl_franchise_info"]) || get_class($GLOBALS["tbl_franchise_info"]) == "ctbl_franchise_info") {
			$GLOBALS["tbl_franchise_info"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_franchise_info"];
		}

		// Table object (tbl_admin)
		if (!isset($GLOBALS['tbl_admin'])) $GLOBALS['tbl_admin'] = new ctbl_admin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_franchise_info', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("tbl_franchise_infolist.php");
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["fld_franchise_ai_id"] != "") {
				$this->fld_franchise_ai_id->setQueryStringValue($_GET["fld_franchise_ai_id"]);
				$this->setKey("fld_franchise_ai_id", $this->fld_franchise_ai_id->CurrentValue); // Set up key
			} else {
				$this->setKey("fld_franchise_ai_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tbl_franchise_infolist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_franchise_infoview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->fld_name->CurrentValue = NULL;
		$this->fld_name->OldValue = $this->fld_name->CurrentValue;
		$this->fld_location->CurrentValue = NULL;
		$this->fld_location->OldValue = $this->fld_location->CurrentValue;
		$this->fld_rating->CurrentValue = 0.00;
		$this->fld_is_active->CurrentValue = "1";
		$this->fld_created_on->CurrentValue = NULL;
		$this->fld_created_on->OldValue = $this->fld_created_on->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->fld_name->FldIsDetailKey) {
			$this->fld_name->setFormValue($objForm->GetValue("x_fld_name"));
		}
		if (!$this->fld_location->FldIsDetailKey) {
			$this->fld_location->setFormValue($objForm->GetValue("x_fld_location"));
		}
		if (!$this->fld_rating->FldIsDetailKey) {
			$this->fld_rating->setFormValue($objForm->GetValue("x_fld_rating"));
		}
		if (!$this->fld_is_active->FldIsDetailKey) {
			$this->fld_is_active->setFormValue($objForm->GetValue("x_fld_is_active"));
		}
		if (!$this->fld_created_on->FldIsDetailKey) {
			$this->fld_created_on->setFormValue($objForm->GetValue("x_fld_created_on"));
			$this->fld_created_on->CurrentValue = ew_UnFormatDateTime($this->fld_created_on->CurrentValue, 9);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->fld_name->CurrentValue = $this->fld_name->FormValue;
		$this->fld_location->CurrentValue = $this->fld_location->FormValue;
		$this->fld_rating->CurrentValue = $this->fld_rating->FormValue;
		$this->fld_is_active->CurrentValue = $this->fld_is_active->FormValue;
		$this->fld_created_on->CurrentValue = $this->fld_created_on->FormValue;
		$this->fld_created_on->CurrentValue = ew_UnFormatDateTime($this->fld_created_on->CurrentValue, 9);
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
		$this->fld_franchise_ai_id->setDbValue($rs->fields('fld_franchise_ai_id'));
		$this->fld_name->setDbValue($rs->fields('fld_name'));
		$this->fld_location->setDbValue($rs->fields('fld_location'));
		$this->fld_rating->setDbValue($rs->fields('fld_rating'));
		$this->fld_is_active->setDbValue($rs->fields('fld_is_active'));
		$this->fld_created_on->setDbValue($rs->fields('fld_created_on'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->fld_franchise_ai_id->DbValue = $row['fld_franchise_ai_id'];
		$this->fld_name->DbValue = $row['fld_name'];
		$this->fld_location->DbValue = $row['fld_location'];
		$this->fld_rating->DbValue = $row['fld_rating'];
		$this->fld_is_active->DbValue = $row['fld_is_active'];
		$this->fld_created_on->DbValue = $row['fld_created_on'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("fld_franchise_ai_id")) <> "")
			$this->fld_franchise_ai_id->CurrentValue = $this->getKey("fld_franchise_ai_id"); // fld_franchise_ai_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		// fld_franchise_ai_id
		// fld_name
		// fld_location
		// fld_rating
		// fld_is_active
		// fld_created_on

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// fld_franchise_ai_id
			$this->fld_franchise_ai_id->ViewValue = $this->fld_franchise_ai_id->CurrentValue;
			$this->fld_franchise_ai_id->ViewCustomAttributes = "";

			// fld_name
			$this->fld_name->ViewValue = $this->fld_name->CurrentValue;
			$this->fld_name->ViewCustomAttributes = "";

			// fld_location
			$this->fld_location->ViewValue = $this->fld_location->CurrentValue;
			$this->fld_location->ViewCustomAttributes = "";

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

			// fld_created_on
			$this->fld_created_on->ViewValue = $this->fld_created_on->CurrentValue;
			$this->fld_created_on->ViewValue = ew_FormatDateTime($this->fld_created_on->ViewValue, 9);
			$this->fld_created_on->ViewCustomAttributes = "";

			// fld_name
			$this->fld_name->LinkCustomAttributes = "";
			$this->fld_name->HrefValue = "";
			$this->fld_name->TooltipValue = "";

			// fld_location
			$this->fld_location->LinkCustomAttributes = "";
			$this->fld_location->HrefValue = "";
			$this->fld_location->TooltipValue = "";

			// fld_rating
			$this->fld_rating->LinkCustomAttributes = "";
			$this->fld_rating->HrefValue = "";
			$this->fld_rating->TooltipValue = "";

			// fld_is_active
			$this->fld_is_active->LinkCustomAttributes = "";
			$this->fld_is_active->HrefValue = "";
			$this->fld_is_active->TooltipValue = "";

			// fld_created_on
			$this->fld_created_on->LinkCustomAttributes = "";
			$this->fld_created_on->HrefValue = "";
			$this->fld_created_on->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// fld_name
			$this->fld_name->EditCustomAttributes = "";
			$this->fld_name->EditValue = ew_HtmlEncode($this->fld_name->CurrentValue);
			$this->fld_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_name->FldCaption()));

			// fld_location
			$this->fld_location->EditCustomAttributes = "";
			$this->fld_location->EditValue = ew_HtmlEncode($this->fld_location->CurrentValue);
			$this->fld_location->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_location->FldCaption()));

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

			// fld_created_on
			$this->fld_created_on->EditCustomAttributes = "";
			$this->fld_created_on->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fld_created_on->CurrentValue, 9));
			$this->fld_created_on->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_created_on->FldCaption()));

			// Edit refer script
			// fld_name

			$this->fld_name->HrefValue = "";

			// fld_location
			$this->fld_location->HrefValue = "";

			// fld_rating
			$this->fld_rating->HrefValue = "";

			// fld_is_active
			$this->fld_is_active->HrefValue = "";

			// fld_created_on
			$this->fld_created_on->HrefValue = "";
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
		if (!$this->fld_name->FldIsDetailKey && !is_null($this->fld_name->FormValue) && $this->fld_name->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_name->FldCaption());
		}
		if (!$this->fld_location->FldIsDetailKey && !is_null($this->fld_location->FormValue) && $this->fld_location->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_location->FldCaption());
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
		if (!$this->fld_created_on->FldIsDetailKey && !is_null($this->fld_created_on->FormValue) && $this->fld_created_on->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_created_on->FldCaption());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// fld_name
		$this->fld_name->SetDbValueDef($rsnew, $this->fld_name->CurrentValue, NULL, FALSE);

		// fld_location
		$this->fld_location->SetDbValueDef($rsnew, $this->fld_location->CurrentValue, NULL, FALSE);

		// fld_rating
		$this->fld_rating->SetDbValueDef($rsnew, $this->fld_rating->CurrentValue, NULL, strval($this->fld_rating->CurrentValue) == "");

		// fld_is_active
		$this->fld_is_active->SetDbValueDef($rsnew, ((strval($this->fld_is_active->CurrentValue) == "1") ? "1" : "0"), NULL, strval($this->fld_is_active->CurrentValue) == "");

		// fld_created_on
		$this->fld_created_on->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fld_created_on->CurrentValue, 9), NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->fld_franchise_ai_id->setDbValue($conn->Insert_ID());
			$rsnew['fld_franchise_ai_id'] = $this->fld_franchise_ai_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "tbl_franchise_infolist.php", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, ew_CurrentUrl());
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
if (!isset($tbl_franchise_info_add)) $tbl_franchise_info_add = new ctbl_franchise_info_add();

// Page init
$tbl_franchise_info_add->Page_Init();

// Page main
$tbl_franchise_info_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_franchise_info_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_franchise_info_add = new ew_Page("tbl_franchise_info_add");
tbl_franchise_info_add.PageID = "add"; // Page ID
var EW_PAGE_ID = tbl_franchise_info_add.PageID; // For backward compatibility

// Form object
var ftbl_franchise_infoadd = new ew_Form("ftbl_franchise_infoadd");

// Validate form
ftbl_franchise_infoadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_fld_name");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_franchise_info->fld_name->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_location");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_franchise_info->fld_location->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_rating");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_franchise_info->fld_rating->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_rating");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_franchise_info->fld_rating->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_is_active");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_franchise_info->fld_is_active->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_created_on");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_franchise_info->fld_created_on->FldCaption()) ?>");

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
ftbl_franchise_infoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_franchise_infoadd.ValidateRequired = true;
<?php } else { ?>
ftbl_franchise_infoadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_franchise_info_add->ShowPageHeader(); ?>
<?php
$tbl_franchise_info_add->ShowMessage();
?>
<form name="ftbl_franchise_infoadd" id="ftbl_franchise_infoadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_franchise_info">
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewGrid"><tr><td>
<table id="tbl_tbl_franchise_infoadd" class="table table-bordered table-striped">
<?php if ($tbl_franchise_info->fld_name->Visible) { // fld_name ?>
	<tr id="r_fld_name">
		<td><span id="elh_tbl_franchise_info_fld_name"><?php echo $tbl_franchise_info->fld_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_franchise_info->fld_name->CellAttributes() ?>>
<span id="el_tbl_franchise_info_fld_name" class="control-group">
<input type="text" data-field="x_fld_name" name="x_fld_name" id="x_fld_name" size="30" maxlength="50" placeholder="<?php echo $tbl_franchise_info->fld_name->PlaceHolder ?>" value="<?php echo $tbl_franchise_info->fld_name->EditValue ?>"<?php echo $tbl_franchise_info->fld_name->EditAttributes() ?>>
</span>
<?php echo $tbl_franchise_info->fld_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_franchise_info->fld_location->Visible) { // fld_location ?>
	<tr id="r_fld_location">
		<td><span id="elh_tbl_franchise_info_fld_location"><?php echo $tbl_franchise_info->fld_location->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_franchise_info->fld_location->CellAttributes() ?>>
<span id="el_tbl_franchise_info_fld_location" class="control-group">
<input type="text" data-field="x_fld_location" name="x_fld_location" id="x_fld_location" size="30" maxlength="20" placeholder="<?php echo $tbl_franchise_info->fld_location->PlaceHolder ?>" value="<?php echo $tbl_franchise_info->fld_location->EditValue ?>"<?php echo $tbl_franchise_info->fld_location->EditAttributes() ?>>
</span>
<?php echo $tbl_franchise_info->fld_location->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_franchise_info->fld_rating->Visible) { // fld_rating ?>
	<tr id="r_fld_rating">
		<td><span id="elh_tbl_franchise_info_fld_rating"><?php echo $tbl_franchise_info->fld_rating->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_franchise_info->fld_rating->CellAttributes() ?>>
<span id="el_tbl_franchise_info_fld_rating" class="control-group">
<input type="text" data-field="x_fld_rating" name="x_fld_rating" id="x_fld_rating" size="30" placeholder="<?php echo $tbl_franchise_info->fld_rating->PlaceHolder ?>" value="<?php echo $tbl_franchise_info->fld_rating->EditValue ?>"<?php echo $tbl_franchise_info->fld_rating->EditAttributes() ?>>
</span>
<?php echo $tbl_franchise_info->fld_rating->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_franchise_info->fld_is_active->Visible) { // fld_is_active ?>
	<tr id="r_fld_is_active">
		<td><span id="elh_tbl_franchise_info_fld_is_active"><?php echo $tbl_franchise_info->fld_is_active->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_franchise_info->fld_is_active->CellAttributes() ?>>
<span id="el_tbl_franchise_info_fld_is_active" class="control-group">
<div id="tp_x_fld_is_active" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_active" id="x_fld_is_active" value="{value}"<?php echo $tbl_franchise_info->fld_is_active->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_active" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_franchise_info->fld_is_active->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_franchise_info->fld_is_active->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_is_active" name="x_fld_is_active" id="x_fld_is_active_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_franchise_info->fld_is_active->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_franchise_info->fld_is_active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_franchise_info->fld_created_on->Visible) { // fld_created_on ?>
	<tr id="r_fld_created_on">
		<td><span id="elh_tbl_franchise_info_fld_created_on"><?php echo $tbl_franchise_info->fld_created_on->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_franchise_info->fld_created_on->CellAttributes() ?>>
<span id="el_tbl_franchise_info_fld_created_on" class="control-group">
<input type="text" data-field="x_fld_created_on" name="x_fld_created_on" id="x_fld_created_on" placeholder="<?php echo $tbl_franchise_info->fld_created_on->PlaceHolder ?>" value="<?php echo $tbl_franchise_info->fld_created_on->EditValue ?>"<?php echo $tbl_franchise_info->fld_created_on->EditAttributes() ?>>
</span>
<?php echo $tbl_franchise_info->fld_created_on->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
ftbl_franchise_infoadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_franchise_info_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_franchise_info_add->Page_Terminate();
?>
