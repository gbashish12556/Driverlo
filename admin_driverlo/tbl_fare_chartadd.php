<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_fare_chartinfo.php" ?>
<?php include_once "tbl_admininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$tbl_fare_chart_add = NULL; // Initialize page object first

class ctbl_fare_chart_add extends ctbl_fare_chart {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}";

	// Table name
	var $TableName = 'tbl_fare_chart';

	// Page object name
	var $PageObjName = 'tbl_fare_chart_add';

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

		// Table object (tbl_fare_chart)
		if (!isset($GLOBALS["tbl_fare_chart"]) || get_class($GLOBALS["tbl_fare_chart"]) == "ctbl_fare_chart") {
			$GLOBALS["tbl_fare_chart"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_fare_chart"];
		}

		// Table object (tbl_admin)
		if (!isset($GLOBALS['tbl_admin'])) $GLOBALS['tbl_admin'] = new ctbl_admin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_fare_chart', TRUE);

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
			$this->Page_Terminate("tbl_fare_chartlist.php");
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
			if (@$_GET["fld_city_id"] != "") {
				$this->fld_city_id->setQueryStringValue($_GET["fld_city_id"]);
				$this->setKey("fld_city_id", $this->fld_city_id->CurrentValue); // Set up key
			} else {
				$this->setKey("fld_city_id", ""); // Clear key
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
					$this->Page_Terminate("tbl_fare_chartlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tbl_fare_chartview.php")
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
		$this->fld_city_name->CurrentValue = "DefaultIsNothing";
		$this->fld_city_lat->CurrentValue = 22.60000038;
		$this->fld_city_lng->CurrentValue = 88.34999847;
		$this->fld_base_fare->CurrentValue = NULL;
		$this->fld_base_fare->OldValue = $this->fld_base_fare->CurrentValue;
		$this->fld_fare->CurrentValue = NULL;
		$this->fld_fare->OldValue = $this->fld_fare->CurrentValue;
		$this->fld_night_charge->CurrentValue = NULL;
		$this->fld_night_charge->OldValue = $this->fld_night_charge->CurrentValue;
		$this->fld_return_charge->CurrentValue = NULL;
		$this->fld_return_charge->OldValue = $this->fld_return_charge->CurrentValue;
		$this->fld_outstation_base_fare->CurrentValue = NULL;
		$this->fld_outstation_base_fare->OldValue = $this->fld_outstation_base_fare->CurrentValue;
		$this->fld_outstation_fare->CurrentValue = NULL;
		$this->fld_outstation_fare->OldValue = $this->fld_outstation_fare->CurrentValue;
		$this->fld_is_active->CurrentValue = "1";
		$this->fld_created_on->CurrentValue = NULL;
		$this->fld_created_on->OldValue = $this->fld_created_on->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->fld_city_name->FldIsDetailKey) {
			$this->fld_city_name->setFormValue($objForm->GetValue("x_fld_city_name"));
		}
		if (!$this->fld_city_lat->FldIsDetailKey) {
			$this->fld_city_lat->setFormValue($objForm->GetValue("x_fld_city_lat"));
		}
		if (!$this->fld_city_lng->FldIsDetailKey) {
			$this->fld_city_lng->setFormValue($objForm->GetValue("x_fld_city_lng"));
		}
		if (!$this->fld_base_fare->FldIsDetailKey) {
			$this->fld_base_fare->setFormValue($objForm->GetValue("x_fld_base_fare"));
		}
		if (!$this->fld_fare->FldIsDetailKey) {
			$this->fld_fare->setFormValue($objForm->GetValue("x_fld_fare"));
		}
		if (!$this->fld_night_charge->FldIsDetailKey) {
			$this->fld_night_charge->setFormValue($objForm->GetValue("x_fld_night_charge"));
		}
		if (!$this->fld_return_charge->FldIsDetailKey) {
			$this->fld_return_charge->setFormValue($objForm->GetValue("x_fld_return_charge"));
		}
		if (!$this->fld_outstation_base_fare->FldIsDetailKey) {
			$this->fld_outstation_base_fare->setFormValue($objForm->GetValue("x_fld_outstation_base_fare"));
		}
		if (!$this->fld_outstation_fare->FldIsDetailKey) {
			$this->fld_outstation_fare->setFormValue($objForm->GetValue("x_fld_outstation_fare"));
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
		$this->fld_city_name->CurrentValue = $this->fld_city_name->FormValue;
		$this->fld_city_lat->CurrentValue = $this->fld_city_lat->FormValue;
		$this->fld_city_lng->CurrentValue = $this->fld_city_lng->FormValue;
		$this->fld_base_fare->CurrentValue = $this->fld_base_fare->FormValue;
		$this->fld_fare->CurrentValue = $this->fld_fare->FormValue;
		$this->fld_night_charge->CurrentValue = $this->fld_night_charge->FormValue;
		$this->fld_return_charge->CurrentValue = $this->fld_return_charge->FormValue;
		$this->fld_outstation_base_fare->CurrentValue = $this->fld_outstation_base_fare->FormValue;
		$this->fld_outstation_fare->CurrentValue = $this->fld_outstation_fare->FormValue;
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
		$this->fld_city_id->setDbValue($rs->fields('fld_city_id'));
		$this->fld_city_name->setDbValue($rs->fields('fld_city_name'));
		$this->fld_city_lat->setDbValue($rs->fields('fld_city_lat'));
		$this->fld_city_lng->setDbValue($rs->fields('fld_city_lng'));
		$this->fld_base_fare->setDbValue($rs->fields('fld_base_fare'));
		$this->fld_fare->setDbValue($rs->fields('fld_fare'));
		$this->fld_night_charge->setDbValue($rs->fields('fld_night_charge'));
		$this->fld_return_charge->setDbValue($rs->fields('fld_return_charge'));
		$this->fld_outstation_base_fare->setDbValue($rs->fields('fld_outstation_base_fare'));
		$this->fld_outstation_fare->setDbValue($rs->fields('fld_outstation_fare'));
		$this->fld_is_active->setDbValue($rs->fields('fld_is_active'));
		$this->fld_created_on->setDbValue($rs->fields('fld_created_on'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->fld_city_id->DbValue = $row['fld_city_id'];
		$this->fld_city_name->DbValue = $row['fld_city_name'];
		$this->fld_city_lat->DbValue = $row['fld_city_lat'];
		$this->fld_city_lng->DbValue = $row['fld_city_lng'];
		$this->fld_base_fare->DbValue = $row['fld_base_fare'];
		$this->fld_fare->DbValue = $row['fld_fare'];
		$this->fld_night_charge->DbValue = $row['fld_night_charge'];
		$this->fld_return_charge->DbValue = $row['fld_return_charge'];
		$this->fld_outstation_base_fare->DbValue = $row['fld_outstation_base_fare'];
		$this->fld_outstation_fare->DbValue = $row['fld_outstation_fare'];
		$this->fld_is_active->DbValue = $row['fld_is_active'];
		$this->fld_created_on->DbValue = $row['fld_created_on'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("fld_city_id")) <> "")
			$this->fld_city_id->CurrentValue = $this->getKey("fld_city_id"); // fld_city_id
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

		if ($this->fld_city_lat->FormValue == $this->fld_city_lat->CurrentValue && is_numeric(ew_StrToFloat($this->fld_city_lat->CurrentValue)))
			$this->fld_city_lat->CurrentValue = ew_StrToFloat($this->fld_city_lat->CurrentValue);

		// Convert decimal values if posted back
		if ($this->fld_city_lng->FormValue == $this->fld_city_lng->CurrentValue && is_numeric(ew_StrToFloat($this->fld_city_lng->CurrentValue)))
			$this->fld_city_lng->CurrentValue = ew_StrToFloat($this->fld_city_lng->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// fld_city_id
		// fld_city_name
		// fld_city_lat
		// fld_city_lng
		// fld_base_fare
		// fld_fare
		// fld_night_charge
		// fld_return_charge
		// fld_outstation_base_fare
		// fld_outstation_fare
		// fld_is_active
		// fld_created_on

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// fld_city_id
			$this->fld_city_id->ViewValue = $this->fld_city_id->CurrentValue;
			$this->fld_city_id->ViewCustomAttributes = "";

			// fld_city_name
			$this->fld_city_name->ViewValue = $this->fld_city_name->CurrentValue;
			$this->fld_city_name->ViewCustomAttributes = "";

			// fld_city_lat
			$this->fld_city_lat->ViewValue = $this->fld_city_lat->CurrentValue;
			$this->fld_city_lat->ViewCustomAttributes = "";

			// fld_city_lng
			$this->fld_city_lng->ViewValue = $this->fld_city_lng->CurrentValue;
			$this->fld_city_lng->ViewCustomAttributes = "";

			// fld_base_fare
			$this->fld_base_fare->ViewValue = $this->fld_base_fare->CurrentValue;
			$this->fld_base_fare->ViewCustomAttributes = "";

			// fld_fare
			$this->fld_fare->ViewValue = $this->fld_fare->CurrentValue;
			$this->fld_fare->ViewCustomAttributes = "";

			// fld_night_charge
			$this->fld_night_charge->ViewValue = $this->fld_night_charge->CurrentValue;
			$this->fld_night_charge->ViewCustomAttributes = "";

			// fld_return_charge
			$this->fld_return_charge->ViewValue = $this->fld_return_charge->CurrentValue;
			$this->fld_return_charge->ViewCustomAttributes = "";

			// fld_outstation_base_fare
			$this->fld_outstation_base_fare->ViewValue = $this->fld_outstation_base_fare->CurrentValue;
			$this->fld_outstation_base_fare->ViewCustomAttributes = "";

			// fld_outstation_fare
			$this->fld_outstation_fare->ViewValue = $this->fld_outstation_fare->CurrentValue;
			$this->fld_outstation_fare->ViewCustomAttributes = "";

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

			// fld_city_name
			$this->fld_city_name->LinkCustomAttributes = "";
			$this->fld_city_name->HrefValue = "";
			$this->fld_city_name->TooltipValue = "";

			// fld_city_lat
			$this->fld_city_lat->LinkCustomAttributes = "";
			$this->fld_city_lat->HrefValue = "";
			$this->fld_city_lat->TooltipValue = "";

			// fld_city_lng
			$this->fld_city_lng->LinkCustomAttributes = "";
			$this->fld_city_lng->HrefValue = "";
			$this->fld_city_lng->TooltipValue = "";

			// fld_base_fare
			$this->fld_base_fare->LinkCustomAttributes = "";
			$this->fld_base_fare->HrefValue = "";
			$this->fld_base_fare->TooltipValue = "";

			// fld_fare
			$this->fld_fare->LinkCustomAttributes = "";
			$this->fld_fare->HrefValue = "";
			$this->fld_fare->TooltipValue = "";

			// fld_night_charge
			$this->fld_night_charge->LinkCustomAttributes = "";
			$this->fld_night_charge->HrefValue = "";
			$this->fld_night_charge->TooltipValue = "";

			// fld_return_charge
			$this->fld_return_charge->LinkCustomAttributes = "";
			$this->fld_return_charge->HrefValue = "";
			$this->fld_return_charge->TooltipValue = "";

			// fld_outstation_base_fare
			$this->fld_outstation_base_fare->LinkCustomAttributes = "";
			$this->fld_outstation_base_fare->HrefValue = "";
			$this->fld_outstation_base_fare->TooltipValue = "";

			// fld_outstation_fare
			$this->fld_outstation_fare->LinkCustomAttributes = "";
			$this->fld_outstation_fare->HrefValue = "";
			$this->fld_outstation_fare->TooltipValue = "";

			// fld_is_active
			$this->fld_is_active->LinkCustomAttributes = "";
			$this->fld_is_active->HrefValue = "";
			$this->fld_is_active->TooltipValue = "";

			// fld_created_on
			$this->fld_created_on->LinkCustomAttributes = "";
			$this->fld_created_on->HrefValue = "";
			$this->fld_created_on->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// fld_city_name
			$this->fld_city_name->EditCustomAttributes = "";
			$this->fld_city_name->EditValue = ew_HtmlEncode($this->fld_city_name->CurrentValue);
			$this->fld_city_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_city_name->FldCaption()));

			// fld_city_lat
			$this->fld_city_lat->EditCustomAttributes = "";
			$this->fld_city_lat->EditValue = ew_HtmlEncode($this->fld_city_lat->CurrentValue);
			$this->fld_city_lat->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_city_lat->FldCaption()));
			if (strval($this->fld_city_lat->EditValue) <> "" && is_numeric($this->fld_city_lat->EditValue)) $this->fld_city_lat->EditValue = ew_FormatNumber($this->fld_city_lat->EditValue, -2, -1, -2, 0);

			// fld_city_lng
			$this->fld_city_lng->EditCustomAttributes = "";
			$this->fld_city_lng->EditValue = ew_HtmlEncode($this->fld_city_lng->CurrentValue);
			$this->fld_city_lng->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_city_lng->FldCaption()));
			if (strval($this->fld_city_lng->EditValue) <> "" && is_numeric($this->fld_city_lng->EditValue)) $this->fld_city_lng->EditValue = ew_FormatNumber($this->fld_city_lng->EditValue, -2, -1, -2, 0);

			// fld_base_fare
			$this->fld_base_fare->EditCustomAttributes = "";
			$this->fld_base_fare->EditValue = ew_HtmlEncode($this->fld_base_fare->CurrentValue);
			$this->fld_base_fare->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_base_fare->FldCaption()));

			// fld_fare
			$this->fld_fare->EditCustomAttributes = "";
			$this->fld_fare->EditValue = ew_HtmlEncode($this->fld_fare->CurrentValue);
			$this->fld_fare->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_fare->FldCaption()));

			// fld_night_charge
			$this->fld_night_charge->EditCustomAttributes = "";
			$this->fld_night_charge->EditValue = ew_HtmlEncode($this->fld_night_charge->CurrentValue);
			$this->fld_night_charge->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_night_charge->FldCaption()));

			// fld_return_charge
			$this->fld_return_charge->EditCustomAttributes = "";
			$this->fld_return_charge->EditValue = ew_HtmlEncode($this->fld_return_charge->CurrentValue);
			$this->fld_return_charge->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_return_charge->FldCaption()));

			// fld_outstation_base_fare
			$this->fld_outstation_base_fare->EditCustomAttributes = "";
			$this->fld_outstation_base_fare->EditValue = ew_HtmlEncode($this->fld_outstation_base_fare->CurrentValue);
			$this->fld_outstation_base_fare->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_outstation_base_fare->FldCaption()));

			// fld_outstation_fare
			$this->fld_outstation_fare->EditCustomAttributes = "";
			$this->fld_outstation_fare->EditValue = ew_HtmlEncode($this->fld_outstation_fare->CurrentValue);
			$this->fld_outstation_fare->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_outstation_fare->FldCaption()));

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
			// fld_city_name

			$this->fld_city_name->HrefValue = "";

			// fld_city_lat
			$this->fld_city_lat->HrefValue = "";

			// fld_city_lng
			$this->fld_city_lng->HrefValue = "";

			// fld_base_fare
			$this->fld_base_fare->HrefValue = "";

			// fld_fare
			$this->fld_fare->HrefValue = "";

			// fld_night_charge
			$this->fld_night_charge->HrefValue = "";

			// fld_return_charge
			$this->fld_return_charge->HrefValue = "";

			// fld_outstation_base_fare
			$this->fld_outstation_base_fare->HrefValue = "";

			// fld_outstation_fare
			$this->fld_outstation_fare->HrefValue = "";

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
		if (!$this->fld_city_name->FldIsDetailKey && !is_null($this->fld_city_name->FormValue) && $this->fld_city_name->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_city_name->FldCaption());
		}
		if (!$this->fld_city_lat->FldIsDetailKey && !is_null($this->fld_city_lat->FormValue) && $this->fld_city_lat->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_city_lat->FldCaption());
		}
		if (!ew_CheckNumber($this->fld_city_lat->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_city_lat->FldErrMsg());
		}
		if (!$this->fld_city_lng->FldIsDetailKey && !is_null($this->fld_city_lng->FormValue) && $this->fld_city_lng->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_city_lng->FldCaption());
		}
		if (!ew_CheckNumber($this->fld_city_lng->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_city_lng->FldErrMsg());
		}
		if (!$this->fld_base_fare->FldIsDetailKey && !is_null($this->fld_base_fare->FormValue) && $this->fld_base_fare->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_base_fare->FldCaption());
		}
		if (!ew_CheckInteger($this->fld_base_fare->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_base_fare->FldErrMsg());
		}
		if (!$this->fld_fare->FldIsDetailKey && !is_null($this->fld_fare->FormValue) && $this->fld_fare->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_fare->FldCaption());
		}
		if (!ew_CheckInteger($this->fld_fare->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_fare->FldErrMsg());
		}
		if (!$this->fld_night_charge->FldIsDetailKey && !is_null($this->fld_night_charge->FormValue) && $this->fld_night_charge->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_night_charge->FldCaption());
		}
		if (!ew_CheckInteger($this->fld_night_charge->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_night_charge->FldErrMsg());
		}
		if (!$this->fld_return_charge->FldIsDetailKey && !is_null($this->fld_return_charge->FormValue) && $this->fld_return_charge->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_return_charge->FldCaption());
		}
		if (!ew_CheckInteger($this->fld_return_charge->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_return_charge->FldErrMsg());
		}
		if (!$this->fld_outstation_base_fare->FldIsDetailKey && !is_null($this->fld_outstation_base_fare->FormValue) && $this->fld_outstation_base_fare->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_outstation_base_fare->FldCaption());
		}
		if (!ew_CheckInteger($this->fld_outstation_base_fare->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_outstation_base_fare->FldErrMsg());
		}
		if (!$this->fld_outstation_fare->FldIsDetailKey && !is_null($this->fld_outstation_fare->FormValue) && $this->fld_outstation_fare->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->fld_outstation_fare->FldCaption());
		}
		if (!ew_CheckInteger($this->fld_outstation_fare->FormValue)) {
			ew_AddMessage($gsFormError, $this->fld_outstation_fare->FldErrMsg());
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

		// fld_city_name
		$this->fld_city_name->SetDbValueDef($rsnew, $this->fld_city_name->CurrentValue, "", strval($this->fld_city_name->CurrentValue) == "");

		// fld_city_lat
		$this->fld_city_lat->SetDbValueDef($rsnew, $this->fld_city_lat->CurrentValue, NULL, strval($this->fld_city_lat->CurrentValue) == "");

		// fld_city_lng
		$this->fld_city_lng->SetDbValueDef($rsnew, $this->fld_city_lng->CurrentValue, NULL, strval($this->fld_city_lng->CurrentValue) == "");

		// fld_base_fare
		$this->fld_base_fare->SetDbValueDef($rsnew, $this->fld_base_fare->CurrentValue, NULL, FALSE);

		// fld_fare
		$this->fld_fare->SetDbValueDef($rsnew, $this->fld_fare->CurrentValue, NULL, FALSE);

		// fld_night_charge
		$this->fld_night_charge->SetDbValueDef($rsnew, $this->fld_night_charge->CurrentValue, NULL, FALSE);

		// fld_return_charge
		$this->fld_return_charge->SetDbValueDef($rsnew, $this->fld_return_charge->CurrentValue, NULL, FALSE);

		// fld_outstation_base_fare
		$this->fld_outstation_base_fare->SetDbValueDef($rsnew, $this->fld_outstation_base_fare->CurrentValue, NULL, FALSE);

		// fld_outstation_fare
		$this->fld_outstation_fare->SetDbValueDef($rsnew, $this->fld_outstation_fare->CurrentValue, NULL, FALSE);

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
			$this->fld_city_id->setDbValue($conn->Insert_ID());
			$rsnew['fld_city_id'] = $this->fld_city_id->DbValue;
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
		$Breadcrumb->Add("list", $this->TableVar, "tbl_fare_chartlist.php", $this->TableVar, TRUE);
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
if (!isset($tbl_fare_chart_add)) $tbl_fare_chart_add = new ctbl_fare_chart_add();

// Page init
$tbl_fare_chart_add->Page_Init();

// Page main
$tbl_fare_chart_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_fare_chart_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_fare_chart_add = new ew_Page("tbl_fare_chart_add");
tbl_fare_chart_add.PageID = "add"; // Page ID
var EW_PAGE_ID = tbl_fare_chart_add.PageID; // For backward compatibility

// Form object
var ftbl_fare_chartadd = new ew_Form("ftbl_fare_chartadd");

// Validate form
ftbl_fare_chartadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_fld_city_name");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_fare_chart->fld_city_name->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_city_lat");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_fare_chart->fld_city_lat->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_city_lat");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_fare_chart->fld_city_lat->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_city_lng");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_fare_chart->fld_city_lng->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_city_lng");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_fare_chart->fld_city_lng->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_base_fare");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_fare_chart->fld_base_fare->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_base_fare");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_fare_chart->fld_base_fare->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_fare");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_fare_chart->fld_fare->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_fare");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_fare_chart->fld_fare->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_night_charge");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_fare_chart->fld_night_charge->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_night_charge");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_fare_chart->fld_night_charge->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_return_charge");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_fare_chart->fld_return_charge->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_return_charge");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_fare_chart->fld_return_charge->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_outstation_base_fare");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_fare_chart->fld_outstation_base_fare->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_outstation_base_fare");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_fare_chart->fld_outstation_base_fare->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_outstation_fare");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_fare_chart->fld_outstation_fare->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_outstation_fare");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tbl_fare_chart->fld_outstation_fare->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fld_is_active");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_fare_chart->fld_is_active->FldCaption()) ?>");
			elm = this.GetElements("x" + infix + "_fld_created_on");
			if (elm && !ew_HasValue(elm))
				return this.OnError(elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($tbl_fare_chart->fld_created_on->FldCaption()) ?>");

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
ftbl_fare_chartadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_fare_chartadd.ValidateRequired = true;
<?php } else { ?>
ftbl_fare_chartadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $tbl_fare_chart_add->ShowPageHeader(); ?>
<?php
$tbl_fare_chart_add->ShowMessage();
?>
<form name="ftbl_fare_chartadd" id="ftbl_fare_chartadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_fare_chart">
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewGrid"><tr><td>
<table id="tbl_tbl_fare_chartadd" class="table table-bordered table-striped">
<?php if ($tbl_fare_chart->fld_city_name->Visible) { // fld_city_name ?>
	<tr id="r_fld_city_name">
		<td><span id="elh_tbl_fare_chart_fld_city_name"><?php echo $tbl_fare_chart->fld_city_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_fare_chart->fld_city_name->CellAttributes() ?>>
<span id="el_tbl_fare_chart_fld_city_name" class="control-group">
<input type="text" data-field="x_fld_city_name" name="x_fld_city_name" id="x_fld_city_name" size="30" maxlength="40" placeholder="<?php echo $tbl_fare_chart->fld_city_name->PlaceHolder ?>" value="<?php echo $tbl_fare_chart->fld_city_name->EditValue ?>"<?php echo $tbl_fare_chart->fld_city_name->EditAttributes() ?>>
</span>
<?php echo $tbl_fare_chart->fld_city_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_fare_chart->fld_city_lat->Visible) { // fld_city_lat ?>
	<tr id="r_fld_city_lat">
		<td><span id="elh_tbl_fare_chart_fld_city_lat"><?php echo $tbl_fare_chart->fld_city_lat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_fare_chart->fld_city_lat->CellAttributes() ?>>
<span id="el_tbl_fare_chart_fld_city_lat" class="control-group">
<input type="text" data-field="x_fld_city_lat" name="x_fld_city_lat" id="x_fld_city_lat" size="30" placeholder="<?php echo $tbl_fare_chart->fld_city_lat->PlaceHolder ?>" value="<?php echo $tbl_fare_chart->fld_city_lat->EditValue ?>"<?php echo $tbl_fare_chart->fld_city_lat->EditAttributes() ?>>
</span>
<?php echo $tbl_fare_chart->fld_city_lat->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_fare_chart->fld_city_lng->Visible) { // fld_city_lng ?>
	<tr id="r_fld_city_lng">
		<td><span id="elh_tbl_fare_chart_fld_city_lng"><?php echo $tbl_fare_chart->fld_city_lng->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_fare_chart->fld_city_lng->CellAttributes() ?>>
<span id="el_tbl_fare_chart_fld_city_lng" class="control-group">
<input type="text" data-field="x_fld_city_lng" name="x_fld_city_lng" id="x_fld_city_lng" size="30" placeholder="<?php echo $tbl_fare_chart->fld_city_lng->PlaceHolder ?>" value="<?php echo $tbl_fare_chart->fld_city_lng->EditValue ?>"<?php echo $tbl_fare_chart->fld_city_lng->EditAttributes() ?>>
</span>
<?php echo $tbl_fare_chart->fld_city_lng->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_fare_chart->fld_base_fare->Visible) { // fld_base_fare ?>
	<tr id="r_fld_base_fare">
		<td><span id="elh_tbl_fare_chart_fld_base_fare"><?php echo $tbl_fare_chart->fld_base_fare->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_fare_chart->fld_base_fare->CellAttributes() ?>>
<span id="el_tbl_fare_chart_fld_base_fare" class="control-group">
<input type="text" data-field="x_fld_base_fare" name="x_fld_base_fare" id="x_fld_base_fare" size="30" placeholder="<?php echo $tbl_fare_chart->fld_base_fare->PlaceHolder ?>" value="<?php echo $tbl_fare_chart->fld_base_fare->EditValue ?>"<?php echo $tbl_fare_chart->fld_base_fare->EditAttributes() ?>>
</span>
<?php echo $tbl_fare_chart->fld_base_fare->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_fare_chart->fld_fare->Visible) { // fld_fare ?>
	<tr id="r_fld_fare">
		<td><span id="elh_tbl_fare_chart_fld_fare"><?php echo $tbl_fare_chart->fld_fare->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_fare_chart->fld_fare->CellAttributes() ?>>
<span id="el_tbl_fare_chart_fld_fare" class="control-group">
<input type="text" data-field="x_fld_fare" name="x_fld_fare" id="x_fld_fare" size="30" placeholder="<?php echo $tbl_fare_chart->fld_fare->PlaceHolder ?>" value="<?php echo $tbl_fare_chart->fld_fare->EditValue ?>"<?php echo $tbl_fare_chart->fld_fare->EditAttributes() ?>>
</span>
<?php echo $tbl_fare_chart->fld_fare->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_fare_chart->fld_night_charge->Visible) { // fld_night_charge ?>
	<tr id="r_fld_night_charge">
		<td><span id="elh_tbl_fare_chart_fld_night_charge"><?php echo $tbl_fare_chart->fld_night_charge->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_fare_chart->fld_night_charge->CellAttributes() ?>>
<span id="el_tbl_fare_chart_fld_night_charge" class="control-group">
<input type="text" data-field="x_fld_night_charge" name="x_fld_night_charge" id="x_fld_night_charge" size="30" placeholder="<?php echo $tbl_fare_chart->fld_night_charge->PlaceHolder ?>" value="<?php echo $tbl_fare_chart->fld_night_charge->EditValue ?>"<?php echo $tbl_fare_chart->fld_night_charge->EditAttributes() ?>>
</span>
<?php echo $tbl_fare_chart->fld_night_charge->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_fare_chart->fld_return_charge->Visible) { // fld_return_charge ?>
	<tr id="r_fld_return_charge">
		<td><span id="elh_tbl_fare_chart_fld_return_charge"><?php echo $tbl_fare_chart->fld_return_charge->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_fare_chart->fld_return_charge->CellAttributes() ?>>
<span id="el_tbl_fare_chart_fld_return_charge" class="control-group">
<input type="text" data-field="x_fld_return_charge" name="x_fld_return_charge" id="x_fld_return_charge" size="30" placeholder="<?php echo $tbl_fare_chart->fld_return_charge->PlaceHolder ?>" value="<?php echo $tbl_fare_chart->fld_return_charge->EditValue ?>"<?php echo $tbl_fare_chart->fld_return_charge->EditAttributes() ?>>
</span>
<?php echo $tbl_fare_chart->fld_return_charge->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_fare_chart->fld_outstation_base_fare->Visible) { // fld_outstation_base_fare ?>
	<tr id="r_fld_outstation_base_fare">
		<td><span id="elh_tbl_fare_chart_fld_outstation_base_fare"><?php echo $tbl_fare_chart->fld_outstation_base_fare->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_fare_chart->fld_outstation_base_fare->CellAttributes() ?>>
<span id="el_tbl_fare_chart_fld_outstation_base_fare" class="control-group">
<input type="text" data-field="x_fld_outstation_base_fare" name="x_fld_outstation_base_fare" id="x_fld_outstation_base_fare" size="30" placeholder="<?php echo $tbl_fare_chart->fld_outstation_base_fare->PlaceHolder ?>" value="<?php echo $tbl_fare_chart->fld_outstation_base_fare->EditValue ?>"<?php echo $tbl_fare_chart->fld_outstation_base_fare->EditAttributes() ?>>
</span>
<?php echo $tbl_fare_chart->fld_outstation_base_fare->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_fare_chart->fld_outstation_fare->Visible) { // fld_outstation_fare ?>
	<tr id="r_fld_outstation_fare">
		<td><span id="elh_tbl_fare_chart_fld_outstation_fare"><?php echo $tbl_fare_chart->fld_outstation_fare->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_fare_chart->fld_outstation_fare->CellAttributes() ?>>
<span id="el_tbl_fare_chart_fld_outstation_fare" class="control-group">
<input type="text" data-field="x_fld_outstation_fare" name="x_fld_outstation_fare" id="x_fld_outstation_fare" size="30" placeholder="<?php echo $tbl_fare_chart->fld_outstation_fare->PlaceHolder ?>" value="<?php echo $tbl_fare_chart->fld_outstation_fare->EditValue ?>"<?php echo $tbl_fare_chart->fld_outstation_fare->EditAttributes() ?>>
</span>
<?php echo $tbl_fare_chart->fld_outstation_fare->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_fare_chart->fld_is_active->Visible) { // fld_is_active ?>
	<tr id="r_fld_is_active">
		<td><span id="elh_tbl_fare_chart_fld_is_active"><?php echo $tbl_fare_chart->fld_is_active->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_fare_chart->fld_is_active->CellAttributes() ?>>
<span id="el_tbl_fare_chart_fld_is_active" class="control-group">
<div id="tp_x_fld_is_active" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_active" id="x_fld_is_active" value="{value}"<?php echo $tbl_fare_chart->fld_is_active->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_active" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_fare_chart->fld_is_active->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_fare_chart->fld_is_active->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_is_active" name="x_fld_is_active" id="x_fld_is_active_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_fare_chart->fld_is_active->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $tbl_fare_chart->fld_is_active->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($tbl_fare_chart->fld_created_on->Visible) { // fld_created_on ?>
	<tr id="r_fld_created_on">
		<td><span id="elh_tbl_fare_chart_fld_created_on"><?php echo $tbl_fare_chart->fld_created_on->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tbl_fare_chart->fld_created_on->CellAttributes() ?>>
<span id="el_tbl_fare_chart_fld_created_on" class="control-group">
<input type="text" data-field="x_fld_created_on" name="x_fld_created_on" id="x_fld_created_on" placeholder="<?php echo $tbl_fare_chart->fld_created_on->PlaceHolder ?>" value="<?php echo $tbl_fare_chart->fld_created_on->EditValue ?>"<?php echo $tbl_fare_chart->fld_created_on->EditAttributes() ?>>
</span>
<?php echo $tbl_fare_chart->fld_created_on->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
ftbl_fare_chartadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_fare_chart_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_fare_chart_add->Page_Terminate();
?>
