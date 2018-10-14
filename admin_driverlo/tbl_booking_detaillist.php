<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "tbl_booking_detailinfo.php" ?>
<?php include_once "tbl_admininfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$tbl_booking_detail_list = NULL; // Initialize page object first

class ctbl_booking_detail_list extends ctbl_booking_detail {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}";

	// Table name
	var $TableName = 'tbl_booking_detail';

	// Page object name
	var $PageObjName = 'tbl_booking_detail_list';

	// Grid form hidden field names
	var $FormName = 'ftbl_booking_detaillist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (tbl_booking_detail)
		if (!isset($GLOBALS["tbl_booking_detail"]) || get_class($GLOBALS["tbl_booking_detail"]) == "ctbl_booking_detail") {
			$GLOBALS["tbl_booking_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_booking_detail"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tbl_booking_detailadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tbl_booking_detaildelete.php";
		$this->MultiUpdateUrl = "tbl_booking_detailupdate.php";

		// Table object (tbl_admin)
		if (!isset($GLOBALS['tbl_admin'])) $GLOBALS['tbl_admin'] = new ctbl_admin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_booking_detail', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage($Language->Phrase("NoPermission")); // Set no permission
			$this->Page_Terminate("login.php");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->fld_booking_ai_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Setup other options
		$this->SetupOtherOptions();

		// Set "checkbox" visible
		if (count($this->CustomActions) > 0)
			$this->ListOptions->Items["checkbox"]->Visible = TRUE;
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process custom action first
			$this->ProcessCustomAction();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide export options
			if ($this->Export <> "" || $this->CurrentAction <> "")
				$this->ExportOptions->HideAllOptions();

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset
			if ($this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->fld_booking_ai_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->fld_booking_ai_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->fld_booking_ai_id, FALSE); // fld_booking_ai_id
		$this->BuildSearchSql($sWhere, $this->fld_pickup_point, FALSE); // fld_pickup_point
		$this->BuildSearchSql($sWhere, $this->fld_customer_name, FALSE); // fld_customer_name
		$this->BuildSearchSql($sWhere, $this->fld_mobile_no, FALSE); // fld_mobile_no
		$this->BuildSearchSql($sWhere, $this->fld_booking_datetime, FALSE); // fld_booking_datetime
		$this->BuildSearchSql($sWhere, $this->fld_coupon_code, FALSE); // fld_coupon_code
		$this->BuildSearchSql($sWhere, $this->fld_driver_rating, FALSE); // fld_driver_rating
		$this->BuildSearchSql($sWhere, $this->fld_customer_feedback, FALSE); // fld_customer_feedback
		$this->BuildSearchSql($sWhere, $this->fld_is_cancelled, FALSE); // fld_is_cancelled
		$this->BuildSearchSql($sWhere, $this->fld_total_fare, FALSE); // fld_total_fare
		$this->BuildSearchSql($sWhere, $this->fld_booked_driver_id, FALSE); // fld_booked_driver_id
		$this->BuildSearchSql($sWhere, $this->fld_is_approved, FALSE); // fld_is_approved
		$this->BuildSearchSql($sWhere, $this->fld_is_completed, FALSE); // fld_is_completed
		$this->BuildSearchSql($sWhere, $this->fld_is_active, FALSE); // fld_is_active
		$this->BuildSearchSql($sWhere, $this->fld_created_on, FALSE); // fld_created_on
		$this->BuildSearchSql($sWhere, $this->fld_dropoff_point, FALSE); // fld_dropoff_point
		$this->BuildSearchSql($sWhere, $this->fld_estimated_time, FALSE); // fld_estimated_time
		$this->BuildSearchSql($sWhere, $this->fld_estimated_fare, FALSE); // fld_estimated_fare
		$this->BuildSearchSql($sWhere, $this->fld_brn_no, FALSE); // fld_brn_no
		$this->BuildSearchSql($sWhere, $this->fld_journey_type, FALSE); // fld_journey_type
		$this->BuildSearchSql($sWhere, $this->fld_vehicle_type, FALSE); // fld_vehicle_type
		$this->BuildSearchSql($sWhere, $this->fld_vehicle_mode, FALSE); // fld_vehicle_mode

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->fld_booking_ai_id->AdvancedSearch->Save(); // fld_booking_ai_id
			$this->fld_pickup_point->AdvancedSearch->Save(); // fld_pickup_point
			$this->fld_customer_name->AdvancedSearch->Save(); // fld_customer_name
			$this->fld_mobile_no->AdvancedSearch->Save(); // fld_mobile_no
			$this->fld_booking_datetime->AdvancedSearch->Save(); // fld_booking_datetime
			$this->fld_coupon_code->AdvancedSearch->Save(); // fld_coupon_code
			$this->fld_driver_rating->AdvancedSearch->Save(); // fld_driver_rating
			$this->fld_customer_feedback->AdvancedSearch->Save(); // fld_customer_feedback
			$this->fld_is_cancelled->AdvancedSearch->Save(); // fld_is_cancelled
			$this->fld_total_fare->AdvancedSearch->Save(); // fld_total_fare
			$this->fld_booked_driver_id->AdvancedSearch->Save(); // fld_booked_driver_id
			$this->fld_is_approved->AdvancedSearch->Save(); // fld_is_approved
			$this->fld_is_completed->AdvancedSearch->Save(); // fld_is_completed
			$this->fld_is_active->AdvancedSearch->Save(); // fld_is_active
			$this->fld_created_on->AdvancedSearch->Save(); // fld_created_on
			$this->fld_dropoff_point->AdvancedSearch->Save(); // fld_dropoff_point
			$this->fld_estimated_time->AdvancedSearch->Save(); // fld_estimated_time
			$this->fld_estimated_fare->AdvancedSearch->Save(); // fld_estimated_fare
			$this->fld_brn_no->AdvancedSearch->Save(); // fld_brn_no
			$this->fld_journey_type->AdvancedSearch->Save(); // fld_journey_type
			$this->fld_vehicle_type->AdvancedSearch->Save(); // fld_vehicle_type
			$this->fld_vehicle_mode->AdvancedSearch->Save(); // fld_vehicle_mode
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		if (is_numeric($Keyword)) $this->BuildBasicSearchSQL($sWhere, $this->fld_mobile_no, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->fld_brn_no, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		if ($Keyword == EW_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NULL";
		} elseif ($Keyword == EW_NOT_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NOT NULL";
		} else {
			$sFldExpression = ($Fld->FldVirtualExpression <> $Fld->FldExpression) ? $Fld->FldVirtualExpression : $Fld->FldBasicSearchExpression;
			$sWrk = $sFldExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING));
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = $this->BasicSearch->Keyword;
		$sSearchType = $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		if ($this->fld_booking_ai_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_pickup_point->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_customer_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_mobile_no->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_booking_datetime->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_coupon_code->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_driver_rating->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_customer_feedback->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_is_cancelled->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_total_fare->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_booked_driver_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_is_approved->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_is_completed->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_is_active->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_created_on->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_dropoff_point->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_estimated_time->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_estimated_fare->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_brn_no->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_journey_type->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_vehicle_type->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_vehicle_mode->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->fld_booking_ai_id->AdvancedSearch->UnsetSession();
		$this->fld_pickup_point->AdvancedSearch->UnsetSession();
		$this->fld_customer_name->AdvancedSearch->UnsetSession();
		$this->fld_mobile_no->AdvancedSearch->UnsetSession();
		$this->fld_booking_datetime->AdvancedSearch->UnsetSession();
		$this->fld_coupon_code->AdvancedSearch->UnsetSession();
		$this->fld_driver_rating->AdvancedSearch->UnsetSession();
		$this->fld_customer_feedback->AdvancedSearch->UnsetSession();
		$this->fld_is_cancelled->AdvancedSearch->UnsetSession();
		$this->fld_total_fare->AdvancedSearch->UnsetSession();
		$this->fld_booked_driver_id->AdvancedSearch->UnsetSession();
		$this->fld_is_approved->AdvancedSearch->UnsetSession();
		$this->fld_is_completed->AdvancedSearch->UnsetSession();
		$this->fld_is_active->AdvancedSearch->UnsetSession();
		$this->fld_created_on->AdvancedSearch->UnsetSession();
		$this->fld_dropoff_point->AdvancedSearch->UnsetSession();
		$this->fld_estimated_time->AdvancedSearch->UnsetSession();
		$this->fld_estimated_fare->AdvancedSearch->UnsetSession();
		$this->fld_brn_no->AdvancedSearch->UnsetSession();
		$this->fld_journey_type->AdvancedSearch->UnsetSession();
		$this->fld_vehicle_type->AdvancedSearch->UnsetSession();
		$this->fld_vehicle_mode->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->fld_booking_ai_id->AdvancedSearch->Load();
		$this->fld_pickup_point->AdvancedSearch->Load();
		$this->fld_customer_name->AdvancedSearch->Load();
		$this->fld_mobile_no->AdvancedSearch->Load();
		$this->fld_booking_datetime->AdvancedSearch->Load();
		$this->fld_coupon_code->AdvancedSearch->Load();
		$this->fld_driver_rating->AdvancedSearch->Load();
		$this->fld_customer_feedback->AdvancedSearch->Load();
		$this->fld_is_cancelled->AdvancedSearch->Load();
		$this->fld_total_fare->AdvancedSearch->Load();
		$this->fld_booked_driver_id->AdvancedSearch->Load();
		$this->fld_is_approved->AdvancedSearch->Load();
		$this->fld_is_completed->AdvancedSearch->Load();
		$this->fld_is_active->AdvancedSearch->Load();
		$this->fld_created_on->AdvancedSearch->Load();
		$this->fld_dropoff_point->AdvancedSearch->Load();
		$this->fld_estimated_time->AdvancedSearch->Load();
		$this->fld_estimated_fare->AdvancedSearch->Load();
		$this->fld_brn_no->AdvancedSearch->Load();
		$this->fld_journey_type->AdvancedSearch->Load();
		$this->fld_vehicle_type->AdvancedSearch->Load();
		$this->fld_vehicle_mode->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->fld_booking_ai_id); // fld_booking_ai_id
			$this->UpdateSort($this->fld_pickup_point); // fld_pickup_point
			$this->UpdateSort($this->fld_customer_name); // fld_customer_name
			$this->UpdateSort($this->fld_mobile_no); // fld_mobile_no
			$this->UpdateSort($this->fld_booking_datetime); // fld_booking_datetime
			$this->UpdateSort($this->fld_coupon_code); // fld_coupon_code
			$this->UpdateSort($this->fld_driver_rating); // fld_driver_rating
			$this->UpdateSort($this->fld_customer_feedback); // fld_customer_feedback
			$this->UpdateSort($this->fld_is_cancelled); // fld_is_cancelled
			$this->UpdateSort($this->fld_total_fare); // fld_total_fare
			$this->UpdateSort($this->fld_booked_driver_id); // fld_booked_driver_id
			$this->UpdateSort($this->fld_is_approved); // fld_is_approved
			$this->UpdateSort($this->fld_is_completed); // fld_is_completed
			$this->UpdateSort($this->fld_is_active); // fld_is_active
			$this->UpdateSort($this->fld_created_on); // fld_created_on
			$this->UpdateSort($this->fld_dropoff_point); // fld_dropoff_point
			$this->UpdateSort($this->fld_estimated_time); // fld_estimated_time
			$this->UpdateSort($this->fld_estimated_fare); // fld_estimated_fare
			$this->UpdateSort($this->fld_brn_no); // fld_brn_no
			$this->UpdateSort($this->fld_journey_type); // fld_journey_type
			$this->UpdateSort($this->fld_vehicle_type); // fld_vehicle_type
			$this->UpdateSort($this->fld_vehicle_mode); // fld_vehicle_mode
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->SqlOrderBy() <> "") {
				$sOrderBy = $this->SqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->fld_booking_ai_id->setSort("");
				$this->fld_pickup_point->setSort("");
				$this->fld_customer_name->setSort("");
				$this->fld_mobile_no->setSort("");
				$this->fld_booking_datetime->setSort("");
				$this->fld_coupon_code->setSort("");
				$this->fld_driver_rating->setSort("");
				$this->fld_customer_feedback->setSort("");
				$this->fld_is_cancelled->setSort("");
				$this->fld_total_fare->setSort("");
				$this->fld_booked_driver_id->setSort("");
				$this->fld_is_approved->setSort("");
				$this->fld_is_completed->setSort("");
				$this->fld_is_active->setSort("");
				$this->fld_created_on->setSort("");
				$this->fld_dropoff_point->setSort("");
				$this->fld_estimated_time->setSort("");
				$this->fld_estimated_fare->setSort("");
				$this->fld_brn_no->setSort("");
				$this->fld_journey_type->setSort("");
				$this->fld_vehicle_type->setSort("");
				$this->fld_vehicle_mode->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = FALSE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\"></label>";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		$this->ListOptions->ButtonClass = "btn-small"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if ($Security->CanView())
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->fld_booking_ai_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'></label>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-small"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];
			foreach ($this->CustomActions as $action => $name) {

				// Add custom action
				$item = &$option->Add("custom_" . $action);
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.ftbl_booking_detaillist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
			}

			// Hide grid edit, multi-delete and multi-update
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$item = &$option->GetItem("multidelete");
				if ($item) $item->Visible = FALSE;
				$item = &$option->GetItem("multiupdate");
				if ($item) $item->Visible = FALSE;
			}
	}

	// Process custom action
	function ProcessCustomAction() {
		global $conn, $Language, $Security;
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$rsuser = ($rs) ? $rs->GetRows() : array();
			if ($rs)
				$rs->Close();

			// Call row custom action event
			if (count($rsuser) > 0) {
				$conn->BeginTrans();
				foreach ($rsuser as $row) {
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCancelled")));
					}
				}
			}
		}
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	//  Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// fld_booking_ai_id

		$this->fld_booking_ai_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_booking_ai_id"]);
		if ($this->fld_booking_ai_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_booking_ai_id->AdvancedSearch->SearchOperator = @$_GET["z_fld_booking_ai_id"];

		// fld_pickup_point
		$this->fld_pickup_point->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_pickup_point"]);
		if ($this->fld_pickup_point->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_pickup_point->AdvancedSearch->SearchOperator = @$_GET["z_fld_pickup_point"];

		// fld_customer_name
		$this->fld_customer_name->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_customer_name"]);
		if ($this->fld_customer_name->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_customer_name->AdvancedSearch->SearchOperator = @$_GET["z_fld_customer_name"];

		// fld_mobile_no
		$this->fld_mobile_no->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_mobile_no"]);
		if ($this->fld_mobile_no->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_mobile_no->AdvancedSearch->SearchOperator = @$_GET["z_fld_mobile_no"];

		// fld_booking_datetime
		$this->fld_booking_datetime->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_booking_datetime"]);
		if ($this->fld_booking_datetime->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_booking_datetime->AdvancedSearch->SearchOperator = @$_GET["z_fld_booking_datetime"];

		// fld_coupon_code
		$this->fld_coupon_code->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_coupon_code"]);
		if ($this->fld_coupon_code->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_coupon_code->AdvancedSearch->SearchOperator = @$_GET["z_fld_coupon_code"];

		// fld_driver_rating
		$this->fld_driver_rating->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_driver_rating"]);
		if ($this->fld_driver_rating->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_driver_rating->AdvancedSearch->SearchOperator = @$_GET["z_fld_driver_rating"];

		// fld_customer_feedback
		$this->fld_customer_feedback->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_customer_feedback"]);
		if ($this->fld_customer_feedback->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_customer_feedback->AdvancedSearch->SearchOperator = @$_GET["z_fld_customer_feedback"];

		// fld_is_cancelled
		$this->fld_is_cancelled->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_is_cancelled"]);
		if ($this->fld_is_cancelled->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_is_cancelled->AdvancedSearch->SearchOperator = @$_GET["z_fld_is_cancelled"];

		// fld_total_fare
		$this->fld_total_fare->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_total_fare"]);
		if ($this->fld_total_fare->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_total_fare->AdvancedSearch->SearchOperator = @$_GET["z_fld_total_fare"];

		// fld_booked_driver_id
		$this->fld_booked_driver_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_booked_driver_id"]);
		if ($this->fld_booked_driver_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_booked_driver_id->AdvancedSearch->SearchOperator = @$_GET["z_fld_booked_driver_id"];

		// fld_is_approved
		$this->fld_is_approved->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_is_approved"]);
		if ($this->fld_is_approved->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_is_approved->AdvancedSearch->SearchOperator = @$_GET["z_fld_is_approved"];

		// fld_is_completed
		$this->fld_is_completed->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_is_completed"]);
		if ($this->fld_is_completed->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_is_completed->AdvancedSearch->SearchOperator = @$_GET["z_fld_is_completed"];

		// fld_is_active
		$this->fld_is_active->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_is_active"]);
		if ($this->fld_is_active->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_is_active->AdvancedSearch->SearchOperator = @$_GET["z_fld_is_active"];

		// fld_created_on
		$this->fld_created_on->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_created_on"]);
		if ($this->fld_created_on->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_created_on->AdvancedSearch->SearchOperator = @$_GET["z_fld_created_on"];

		// fld_dropoff_point
		$this->fld_dropoff_point->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_dropoff_point"]);
		if ($this->fld_dropoff_point->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_dropoff_point->AdvancedSearch->SearchOperator = @$_GET["z_fld_dropoff_point"];

		// fld_estimated_time
		$this->fld_estimated_time->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_estimated_time"]);
		if ($this->fld_estimated_time->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_estimated_time->AdvancedSearch->SearchOperator = @$_GET["z_fld_estimated_time"];

		// fld_estimated_fare
		$this->fld_estimated_fare->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_estimated_fare"]);
		if ($this->fld_estimated_fare->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_estimated_fare->AdvancedSearch->SearchOperator = @$_GET["z_fld_estimated_fare"];

		// fld_brn_no
		$this->fld_brn_no->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_brn_no"]);
		if ($this->fld_brn_no->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_brn_no->AdvancedSearch->SearchOperator = @$_GET["z_fld_brn_no"];

		// fld_journey_type
		$this->fld_journey_type->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_journey_type"]);
		if ($this->fld_journey_type->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_journey_type->AdvancedSearch->SearchOperator = @$_GET["z_fld_journey_type"];

		// fld_vehicle_type
		$this->fld_vehicle_type->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_vehicle_type"]);
		if ($this->fld_vehicle_type->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_vehicle_type->AdvancedSearch->SearchOperator = @$_GET["z_fld_vehicle_type"];

		// fld_vehicle_mode
		$this->fld_vehicle_mode->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_vehicle_mode"]);
		if ($this->fld_vehicle_mode->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_vehicle_mode->AdvancedSearch->SearchOperator = @$_GET["z_fld_vehicle_mode"];
	}

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
		$this->fld_booking_ai_id->setDbValue($rs->fields('fld_booking_ai_id'));
		$this->fld_customer_token->setDbValue($rs->fields('fld_customer_token'));
		$this->fld_pickup_point->setDbValue($rs->fields('fld_pickup_point'));
		$this->fld_customer_name->setDbValue($rs->fields('fld_customer_name'));
		$this->fld_mobile_no->setDbValue($rs->fields('fld_mobile_no'));
		$this->fld_booking_datetime->setDbValue($rs->fields('fld_booking_datetime'));
		$this->fld_coupon_code->setDbValue($rs->fields('fld_coupon_code'));
		$this->fld_driver_rating->setDbValue($rs->fields('fld_driver_rating'));
		$this->fld_customer_feedback->setDbValue($rs->fields('fld_customer_feedback'));
		$this->fld_is_cancelled->setDbValue($rs->fields('fld_is_cancelled'));
		$this->fld_total_fare->setDbValue($rs->fields('fld_total_fare'));
		$this->fld_booked_driver_id->setDbValue($rs->fields('fld_booked_driver_id'));
		$this->fld_is_approved->setDbValue($rs->fields('fld_is_approved'));
		$this->fld_is_completed->setDbValue($rs->fields('fld_is_completed'));
		$this->fld_is_active->setDbValue($rs->fields('fld_is_active'));
		$this->fld_created_on->setDbValue($rs->fields('fld_created_on'));
		$this->fld_dropoff_point->setDbValue($rs->fields('fld_dropoff_point'));
		$this->fld_estimated_time->setDbValue($rs->fields('fld_estimated_time'));
		$this->fld_estimated_fare->setDbValue($rs->fields('fld_estimated_fare'));
		$this->fld_brn_no->setDbValue($rs->fields('fld_brn_no'));
		$this->fld_journey_type->setDbValue($rs->fields('fld_journey_type'));
		$this->fld_vehicle_type->setDbValue($rs->fields('fld_vehicle_type'));
		$this->fld_vehicle_mode->setDbValue($rs->fields('fld_vehicle_mode'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->fld_booking_ai_id->DbValue = $row['fld_booking_ai_id'];
		$this->fld_customer_token->DbValue = $row['fld_customer_token'];
		$this->fld_pickup_point->DbValue = $row['fld_pickup_point'];
		$this->fld_customer_name->DbValue = $row['fld_customer_name'];
		$this->fld_mobile_no->DbValue = $row['fld_mobile_no'];
		$this->fld_booking_datetime->DbValue = $row['fld_booking_datetime'];
		$this->fld_coupon_code->DbValue = $row['fld_coupon_code'];
		$this->fld_driver_rating->DbValue = $row['fld_driver_rating'];
		$this->fld_customer_feedback->DbValue = $row['fld_customer_feedback'];
		$this->fld_is_cancelled->DbValue = $row['fld_is_cancelled'];
		$this->fld_total_fare->DbValue = $row['fld_total_fare'];
		$this->fld_booked_driver_id->DbValue = $row['fld_booked_driver_id'];
		$this->fld_is_approved->DbValue = $row['fld_is_approved'];
		$this->fld_is_completed->DbValue = $row['fld_is_completed'];
		$this->fld_is_active->DbValue = $row['fld_is_active'];
		$this->fld_created_on->DbValue = $row['fld_created_on'];
		$this->fld_dropoff_point->DbValue = $row['fld_dropoff_point'];
		$this->fld_estimated_time->DbValue = $row['fld_estimated_time'];
		$this->fld_estimated_fare->DbValue = $row['fld_estimated_fare'];
		$this->fld_brn_no->DbValue = $row['fld_brn_no'];
		$this->fld_journey_type->DbValue = $row['fld_journey_type'];
		$this->fld_vehicle_type->DbValue = $row['fld_vehicle_type'];
		$this->fld_vehicle_mode->DbValue = $row['fld_vehicle_mode'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("fld_booking_ai_id")) <> "")
			$this->fld_booking_ai_id->CurrentValue = $this->getKey("fld_booking_ai_id"); // fld_booking_ai_id
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Convert decimal values if posted back
		if ($this->fld_driver_rating->FormValue == $this->fld_driver_rating->CurrentValue && is_numeric(ew_StrToFloat($this->fld_driver_rating->CurrentValue)))
			$this->fld_driver_rating->CurrentValue = ew_StrToFloat($this->fld_driver_rating->CurrentValue);

		// Convert decimal values if posted back
		if ($this->fld_total_fare->FormValue == $this->fld_total_fare->CurrentValue && is_numeric(ew_StrToFloat($this->fld_total_fare->CurrentValue)))
			$this->fld_total_fare->CurrentValue = ew_StrToFloat($this->fld_total_fare->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// fld_booking_ai_id
		// fld_customer_token

		$this->fld_customer_token->CellCssStyle = "white-space: nowrap;";

		// fld_pickup_point
		// fld_customer_name
		// fld_mobile_no
		// fld_booking_datetime
		// fld_coupon_code
		// fld_driver_rating
		// fld_customer_feedback
		// fld_is_cancelled
		// fld_total_fare
		// fld_booked_driver_id
		// fld_is_approved
		// fld_is_completed
		// fld_is_active
		// fld_created_on
		// fld_dropoff_point
		// fld_estimated_time
		// fld_estimated_fare
		// fld_brn_no
		// fld_journey_type
		// fld_vehicle_type
		// fld_vehicle_mode

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// fld_booking_ai_id
			$this->fld_booking_ai_id->ViewValue = $this->fld_booking_ai_id->CurrentValue;
			$this->fld_booking_ai_id->ViewCustomAttributes = "";

			// fld_pickup_point
			$this->fld_pickup_point->ViewValue = $this->fld_pickup_point->CurrentValue;
			$this->fld_pickup_point->ViewCustomAttributes = "";

			// fld_customer_name
			$this->fld_customer_name->ViewValue = $this->fld_customer_name->CurrentValue;
			$this->fld_customer_name->ViewCustomAttributes = "";

			// fld_mobile_no
			$this->fld_mobile_no->ViewValue = $this->fld_mobile_no->CurrentValue;
			$this->fld_mobile_no->ViewCustomAttributes = "";

			// fld_booking_datetime
			$this->fld_booking_datetime->ViewValue = $this->fld_booking_datetime->CurrentValue;
			$this->fld_booking_datetime->ViewValue = ew_FormatDateTime($this->fld_booking_datetime->ViewValue, 9);
			$this->fld_booking_datetime->ViewCustomAttributes = "";

			// fld_coupon_code
			$this->fld_coupon_code->ViewValue = $this->fld_coupon_code->CurrentValue;
			$this->fld_coupon_code->ViewCustomAttributes = "";

			// fld_driver_rating
			$this->fld_driver_rating->ViewValue = $this->fld_driver_rating->CurrentValue;
			$this->fld_driver_rating->ViewCustomAttributes = "";

			// fld_customer_feedback
			$this->fld_customer_feedback->ViewValue = $this->fld_customer_feedback->CurrentValue;
			$this->fld_customer_feedback->ViewCustomAttributes = "";

			// fld_is_cancelled
			if (ew_ConvertToBool($this->fld_is_cancelled->CurrentValue)) {
				$this->fld_is_cancelled->ViewValue = $this->fld_is_cancelled->FldTagCaption(1) <> "" ? $this->fld_is_cancelled->FldTagCaption(1) : "1";
			} else {
				$this->fld_is_cancelled->ViewValue = $this->fld_is_cancelled->FldTagCaption(2) <> "" ? $this->fld_is_cancelled->FldTagCaption(2) : "0";
			}
			$this->fld_is_cancelled->ViewCustomAttributes = "";

			// fld_total_fare
			$this->fld_total_fare->ViewValue = $this->fld_total_fare->CurrentValue;
			$this->fld_total_fare->ViewCustomAttributes = "";

			// fld_booked_driver_id
			if (strval($this->fld_booked_driver_id->CurrentValue) <> "") {
				$sFilterWrk = "`fld_driver_ai_id`" . ew_SearchString("=", $this->fld_booked_driver_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `fld_driver_ai_id`, `fld_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_driver_info`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->fld_booked_driver_id, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->fld_booked_driver_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->fld_booked_driver_id->ViewValue = $this->fld_booked_driver_id->CurrentValue;
				}
			} else {
				$this->fld_booked_driver_id->ViewValue = NULL;
			}
			$this->fld_booked_driver_id->ViewCustomAttributes = "";

			// fld_is_approved
			if (ew_ConvertToBool($this->fld_is_approved->CurrentValue)) {
				$this->fld_is_approved->ViewValue = $this->fld_is_approved->FldTagCaption(1) <> "" ? $this->fld_is_approved->FldTagCaption(1) : "1";
			} else {
				$this->fld_is_approved->ViewValue = $this->fld_is_approved->FldTagCaption(2) <> "" ? $this->fld_is_approved->FldTagCaption(2) : "0";
			}
			$this->fld_is_approved->ViewCustomAttributes = "";

			// fld_is_completed
			if (ew_ConvertToBool($this->fld_is_completed->CurrentValue)) {
				$this->fld_is_completed->ViewValue = $this->fld_is_completed->FldTagCaption(1) <> "" ? $this->fld_is_completed->FldTagCaption(1) : "1";
			} else {
				$this->fld_is_completed->ViewValue = $this->fld_is_completed->FldTagCaption(2) <> "" ? $this->fld_is_completed->FldTagCaption(2) : "0";
			}
			$this->fld_is_completed->ViewCustomAttributes = "";

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

			// fld_dropoff_point
			$this->fld_dropoff_point->ViewValue = $this->fld_dropoff_point->CurrentValue;
			$this->fld_dropoff_point->ViewCustomAttributes = "";

			// fld_estimated_time
			$this->fld_estimated_time->ViewValue = $this->fld_estimated_time->CurrentValue;
			$this->fld_estimated_time->ViewCustomAttributes = "";

			// fld_estimated_fare
			$this->fld_estimated_fare->ViewValue = $this->fld_estimated_fare->CurrentValue;
			$this->fld_estimated_fare->ViewCustomAttributes = "";

			// fld_brn_no
			$this->fld_brn_no->ViewValue = $this->fld_brn_no->CurrentValue;
			$this->fld_brn_no->ViewCustomAttributes = "";

			// fld_journey_type
			if (strval($this->fld_journey_type->CurrentValue) <> "") {
				switch ($this->fld_journey_type->CurrentValue) {
					case $this->fld_journey_type->FldTagValue(1):
						$this->fld_journey_type->ViewValue = $this->fld_journey_type->FldTagCaption(1) <> "" ? $this->fld_journey_type->FldTagCaption(1) : $this->fld_journey_type->CurrentValue;
						break;
					case $this->fld_journey_type->FldTagValue(2):
						$this->fld_journey_type->ViewValue = $this->fld_journey_type->FldTagCaption(2) <> "" ? $this->fld_journey_type->FldTagCaption(2) : $this->fld_journey_type->CurrentValue;
						break;
					case $this->fld_journey_type->FldTagValue(3):
						$this->fld_journey_type->ViewValue = $this->fld_journey_type->FldTagCaption(3) <> "" ? $this->fld_journey_type->FldTagCaption(3) : $this->fld_journey_type->CurrentValue;
						break;
					default:
						$this->fld_journey_type->ViewValue = $this->fld_journey_type->CurrentValue;
				}
			} else {
				$this->fld_journey_type->ViewValue = NULL;
			}
			$this->fld_journey_type->ViewCustomAttributes = "";

			// fld_vehicle_type
			if (strval($this->fld_vehicle_type->CurrentValue) <> "") {
				switch ($this->fld_vehicle_type->CurrentValue) {
					case $this->fld_vehicle_type->FldTagValue(1):
						$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->FldTagCaption(1) <> "" ? $this->fld_vehicle_type->FldTagCaption(1) : $this->fld_vehicle_type->CurrentValue;
						break;
					case $this->fld_vehicle_type->FldTagValue(2):
						$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->FldTagCaption(2) <> "" ? $this->fld_vehicle_type->FldTagCaption(2) : $this->fld_vehicle_type->CurrentValue;
						break;
					case $this->fld_vehicle_type->FldTagValue(3):
						$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->FldTagCaption(3) <> "" ? $this->fld_vehicle_type->FldTagCaption(3) : $this->fld_vehicle_type->CurrentValue;
						break;
					case $this->fld_vehicle_type->FldTagValue(4):
						$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->FldTagCaption(4) <> "" ? $this->fld_vehicle_type->FldTagCaption(4) : $this->fld_vehicle_type->CurrentValue;
						break;
					default:
						$this->fld_vehicle_type->ViewValue = $this->fld_vehicle_type->CurrentValue;
				}
			} else {
				$this->fld_vehicle_type->ViewValue = NULL;
			}
			$this->fld_vehicle_type->ViewCustomAttributes = "";

			// fld_vehicle_mode
			if (strval($this->fld_vehicle_mode->CurrentValue) <> "") {
				switch ($this->fld_vehicle_mode->CurrentValue) {
					case $this->fld_vehicle_mode->FldTagValue(1):
						$this->fld_vehicle_mode->ViewValue = $this->fld_vehicle_mode->FldTagCaption(1) <> "" ? $this->fld_vehicle_mode->FldTagCaption(1) : $this->fld_vehicle_mode->CurrentValue;
						break;
					case $this->fld_vehicle_mode->FldTagValue(2):
						$this->fld_vehicle_mode->ViewValue = $this->fld_vehicle_mode->FldTagCaption(2) <> "" ? $this->fld_vehicle_mode->FldTagCaption(2) : $this->fld_vehicle_mode->CurrentValue;
						break;
					default:
						$this->fld_vehicle_mode->ViewValue = $this->fld_vehicle_mode->CurrentValue;
				}
			} else {
				$this->fld_vehicle_mode->ViewValue = NULL;
			}
			$this->fld_vehicle_mode->ViewCustomAttributes = "";

			// fld_booking_ai_id
			$this->fld_booking_ai_id->LinkCustomAttributes = "";
			$this->fld_booking_ai_id->HrefValue = "";
			$this->fld_booking_ai_id->TooltipValue = "";

			// fld_pickup_point
			$this->fld_pickup_point->LinkCustomAttributes = "";
			$this->fld_pickup_point->HrefValue = "";
			$this->fld_pickup_point->TooltipValue = "";

			// fld_customer_name
			$this->fld_customer_name->LinkCustomAttributes = "";
			$this->fld_customer_name->HrefValue = "";
			$this->fld_customer_name->TooltipValue = "";

			// fld_mobile_no
			$this->fld_mobile_no->LinkCustomAttributes = "";
			$this->fld_mobile_no->HrefValue = "";
			$this->fld_mobile_no->TooltipValue = "";

			// fld_booking_datetime
			$this->fld_booking_datetime->LinkCustomAttributes = "";
			$this->fld_booking_datetime->HrefValue = "";
			$this->fld_booking_datetime->TooltipValue = "";

			// fld_coupon_code
			$this->fld_coupon_code->LinkCustomAttributes = "";
			$this->fld_coupon_code->HrefValue = "";
			$this->fld_coupon_code->TooltipValue = "";

			// fld_driver_rating
			$this->fld_driver_rating->LinkCustomAttributes = "";
			$this->fld_driver_rating->HrefValue = "";
			$this->fld_driver_rating->TooltipValue = "";

			// fld_customer_feedback
			$this->fld_customer_feedback->LinkCustomAttributes = "";
			$this->fld_customer_feedback->HrefValue = "";
			$this->fld_customer_feedback->TooltipValue = "";

			// fld_is_cancelled
			$this->fld_is_cancelled->LinkCustomAttributes = "";
			$this->fld_is_cancelled->HrefValue = "";
			$this->fld_is_cancelled->TooltipValue = "";

			// fld_total_fare
			$this->fld_total_fare->LinkCustomAttributes = "";
			$this->fld_total_fare->HrefValue = "";
			$this->fld_total_fare->TooltipValue = "";

			// fld_booked_driver_id
			$this->fld_booked_driver_id->LinkCustomAttributes = "";
			$this->fld_booked_driver_id->HrefValue = "";
			$this->fld_booked_driver_id->TooltipValue = "";

			// fld_is_approved
			$this->fld_is_approved->LinkCustomAttributes = "";
			$this->fld_is_approved->HrefValue = "";
			$this->fld_is_approved->TooltipValue = "";

			// fld_is_completed
			$this->fld_is_completed->LinkCustomAttributes = "";
			$this->fld_is_completed->HrefValue = "";
			$this->fld_is_completed->TooltipValue = "";

			// fld_is_active
			$this->fld_is_active->LinkCustomAttributes = "";
			$this->fld_is_active->HrefValue = "";
			$this->fld_is_active->TooltipValue = "";

			// fld_created_on
			$this->fld_created_on->LinkCustomAttributes = "";
			$this->fld_created_on->HrefValue = "";
			$this->fld_created_on->TooltipValue = "";

			// fld_dropoff_point
			$this->fld_dropoff_point->LinkCustomAttributes = "";
			$this->fld_dropoff_point->HrefValue = "";
			$this->fld_dropoff_point->TooltipValue = "";

			// fld_estimated_time
			$this->fld_estimated_time->LinkCustomAttributes = "";
			$this->fld_estimated_time->HrefValue = "";
			$this->fld_estimated_time->TooltipValue = "";

			// fld_estimated_fare
			$this->fld_estimated_fare->LinkCustomAttributes = "";
			$this->fld_estimated_fare->HrefValue = "";
			$this->fld_estimated_fare->TooltipValue = "";

			// fld_brn_no
			$this->fld_brn_no->LinkCustomAttributes = "";
			$this->fld_brn_no->HrefValue = "";
			$this->fld_brn_no->TooltipValue = "";

			// fld_journey_type
			$this->fld_journey_type->LinkCustomAttributes = "";
			$this->fld_journey_type->HrefValue = "";
			$this->fld_journey_type->TooltipValue = "";

			// fld_vehicle_type
			$this->fld_vehicle_type->LinkCustomAttributes = "";
			$this->fld_vehicle_type->HrefValue = "";
			$this->fld_vehicle_type->TooltipValue = "";

			// fld_vehicle_mode
			$this->fld_vehicle_mode->LinkCustomAttributes = "";
			$this->fld_vehicle_mode->HrefValue = "";
			$this->fld_vehicle_mode->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// fld_booking_ai_id
			$this->fld_booking_ai_id->EditCustomAttributes = "";
			$this->fld_booking_ai_id->EditValue = ew_HtmlEncode($this->fld_booking_ai_id->AdvancedSearch->SearchValue);
			$this->fld_booking_ai_id->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_booking_ai_id->FldCaption()));

			// fld_pickup_point
			$this->fld_pickup_point->EditCustomAttributes = "";
			$this->fld_pickup_point->EditValue = ew_HtmlEncode($this->fld_pickup_point->AdvancedSearch->SearchValue);
			$this->fld_pickup_point->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_pickup_point->FldCaption()));

			// fld_customer_name
			$this->fld_customer_name->EditCustomAttributes = "";
			$this->fld_customer_name->EditValue = ew_HtmlEncode($this->fld_customer_name->AdvancedSearch->SearchValue);
			$this->fld_customer_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_customer_name->FldCaption()));

			// fld_mobile_no
			$this->fld_mobile_no->EditCustomAttributes = "";
			$this->fld_mobile_no->EditValue = ew_HtmlEncode($this->fld_mobile_no->AdvancedSearch->SearchValue);
			$this->fld_mobile_no->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_mobile_no->FldCaption()));

			// fld_booking_datetime
			$this->fld_booking_datetime->EditCustomAttributes = "";
			$this->fld_booking_datetime->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->fld_booking_datetime->AdvancedSearch->SearchValue, 9), 9));
			$this->fld_booking_datetime->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_booking_datetime->FldCaption()));

			// fld_coupon_code
			$this->fld_coupon_code->EditCustomAttributes = "";
			$this->fld_coupon_code->EditValue = ew_HtmlEncode($this->fld_coupon_code->AdvancedSearch->SearchValue);
			$this->fld_coupon_code->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_coupon_code->FldCaption()));

			// fld_driver_rating
			$this->fld_driver_rating->EditCustomAttributes = "";
			$this->fld_driver_rating->EditValue = ew_HtmlEncode($this->fld_driver_rating->AdvancedSearch->SearchValue);
			$this->fld_driver_rating->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_driver_rating->FldCaption()));

			// fld_customer_feedback
			$this->fld_customer_feedback->EditCustomAttributes = "";
			$this->fld_customer_feedback->EditValue = ew_HtmlEncode($this->fld_customer_feedback->AdvancedSearch->SearchValue);
			$this->fld_customer_feedback->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_customer_feedback->FldCaption()));

			// fld_is_cancelled
			$this->fld_is_cancelled->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_cancelled->FldTagValue(1), $this->fld_is_cancelled->FldTagCaption(1) <> "" ? $this->fld_is_cancelled->FldTagCaption(1) : $this->fld_is_cancelled->FldTagValue(1));
			$arwrk[] = array($this->fld_is_cancelled->FldTagValue(2), $this->fld_is_cancelled->FldTagCaption(2) <> "" ? $this->fld_is_cancelled->FldTagCaption(2) : $this->fld_is_cancelled->FldTagValue(2));
			$this->fld_is_cancelled->EditValue = $arwrk;

			// fld_total_fare
			$this->fld_total_fare->EditCustomAttributes = "";
			$this->fld_total_fare->EditValue = ew_HtmlEncode($this->fld_total_fare->AdvancedSearch->SearchValue);
			$this->fld_total_fare->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_total_fare->FldCaption()));

			// fld_booked_driver_id
			$this->fld_booked_driver_id->EditCustomAttributes = "";

			// fld_is_approved
			$this->fld_is_approved->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_approved->FldTagValue(1), $this->fld_is_approved->FldTagCaption(1) <> "" ? $this->fld_is_approved->FldTagCaption(1) : $this->fld_is_approved->FldTagValue(1));
			$arwrk[] = array($this->fld_is_approved->FldTagValue(2), $this->fld_is_approved->FldTagCaption(2) <> "" ? $this->fld_is_approved->FldTagCaption(2) : $this->fld_is_approved->FldTagValue(2));
			$this->fld_is_approved->EditValue = $arwrk;

			// fld_is_completed
			$this->fld_is_completed->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_completed->FldTagValue(1), $this->fld_is_completed->FldTagCaption(1) <> "" ? $this->fld_is_completed->FldTagCaption(1) : $this->fld_is_completed->FldTagValue(1));
			$arwrk[] = array($this->fld_is_completed->FldTagValue(2), $this->fld_is_completed->FldTagCaption(2) <> "" ? $this->fld_is_completed->FldTagCaption(2) : $this->fld_is_completed->FldTagValue(2));
			$this->fld_is_completed->EditValue = $arwrk;

			// fld_is_active
			$this->fld_is_active->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_is_active->FldTagValue(1), $this->fld_is_active->FldTagCaption(1) <> "" ? $this->fld_is_active->FldTagCaption(1) : $this->fld_is_active->FldTagValue(1));
			$arwrk[] = array($this->fld_is_active->FldTagValue(2), $this->fld_is_active->FldTagCaption(2) <> "" ? $this->fld_is_active->FldTagCaption(2) : $this->fld_is_active->FldTagValue(2));
			$this->fld_is_active->EditValue = $arwrk;

			// fld_created_on
			$this->fld_created_on->EditCustomAttributes = "";
			$this->fld_created_on->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->fld_created_on->AdvancedSearch->SearchValue, 9), 9));
			$this->fld_created_on->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_created_on->FldCaption()));

			// fld_dropoff_point
			$this->fld_dropoff_point->EditCustomAttributes = "";
			$this->fld_dropoff_point->EditValue = ew_HtmlEncode($this->fld_dropoff_point->AdvancedSearch->SearchValue);
			$this->fld_dropoff_point->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_dropoff_point->FldCaption()));

			// fld_estimated_time
			$this->fld_estimated_time->EditCustomAttributes = "";
			$this->fld_estimated_time->EditValue = ew_HtmlEncode($this->fld_estimated_time->AdvancedSearch->SearchValue);
			$this->fld_estimated_time->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_estimated_time->FldCaption()));

			// fld_estimated_fare
			$this->fld_estimated_fare->EditCustomAttributes = "";
			$this->fld_estimated_fare->EditValue = ew_HtmlEncode($this->fld_estimated_fare->AdvancedSearch->SearchValue);
			$this->fld_estimated_fare->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_estimated_fare->FldCaption()));

			// fld_brn_no
			$this->fld_brn_no->EditCustomAttributes = "";
			$this->fld_brn_no->EditValue = ew_HtmlEncode($this->fld_brn_no->AdvancedSearch->SearchValue);
			$this->fld_brn_no->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_brn_no->FldCaption()));

			// fld_journey_type
			$this->fld_journey_type->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_journey_type->FldTagValue(1), $this->fld_journey_type->FldTagCaption(1) <> "" ? $this->fld_journey_type->FldTagCaption(1) : $this->fld_journey_type->FldTagValue(1));
			$arwrk[] = array($this->fld_journey_type->FldTagValue(2), $this->fld_journey_type->FldTagCaption(2) <> "" ? $this->fld_journey_type->FldTagCaption(2) : $this->fld_journey_type->FldTagValue(2));
			$arwrk[] = array($this->fld_journey_type->FldTagValue(3), $this->fld_journey_type->FldTagCaption(3) <> "" ? $this->fld_journey_type->FldTagCaption(3) : $this->fld_journey_type->FldTagValue(3));
			$this->fld_journey_type->EditValue = $arwrk;

			// fld_vehicle_type
			$this->fld_vehicle_type->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_vehicle_type->FldTagValue(1), $this->fld_vehicle_type->FldTagCaption(1) <> "" ? $this->fld_vehicle_type->FldTagCaption(1) : $this->fld_vehicle_type->FldTagValue(1));
			$arwrk[] = array($this->fld_vehicle_type->FldTagValue(2), $this->fld_vehicle_type->FldTagCaption(2) <> "" ? $this->fld_vehicle_type->FldTagCaption(2) : $this->fld_vehicle_type->FldTagValue(2));
			$arwrk[] = array($this->fld_vehicle_type->FldTagValue(3), $this->fld_vehicle_type->FldTagCaption(3) <> "" ? $this->fld_vehicle_type->FldTagCaption(3) : $this->fld_vehicle_type->FldTagValue(3));
			$arwrk[] = array($this->fld_vehicle_type->FldTagValue(4), $this->fld_vehicle_type->FldTagCaption(4) <> "" ? $this->fld_vehicle_type->FldTagCaption(4) : $this->fld_vehicle_type->FldTagValue(4));
			$this->fld_vehicle_type->EditValue = $arwrk;

			// fld_vehicle_mode
			$this->fld_vehicle_mode->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->fld_vehicle_mode->FldTagValue(1), $this->fld_vehicle_mode->FldTagCaption(1) <> "" ? $this->fld_vehicle_mode->FldTagCaption(1) : $this->fld_vehicle_mode->FldTagValue(1));
			$arwrk[] = array($this->fld_vehicle_mode->FldTagValue(2), $this->fld_vehicle_mode->FldTagCaption(2) <> "" ? $this->fld_vehicle_mode->FldTagCaption(2) : $this->fld_vehicle_mode->FldTagValue(2));
			$this->fld_vehicle_mode->EditValue = $arwrk;
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->fld_booking_ai_id->AdvancedSearch->Load();
		$this->fld_pickup_point->AdvancedSearch->Load();
		$this->fld_customer_name->AdvancedSearch->Load();
		$this->fld_mobile_no->AdvancedSearch->Load();
		$this->fld_booking_datetime->AdvancedSearch->Load();
		$this->fld_coupon_code->AdvancedSearch->Load();
		$this->fld_driver_rating->AdvancedSearch->Load();
		$this->fld_customer_feedback->AdvancedSearch->Load();
		$this->fld_is_cancelled->AdvancedSearch->Load();
		$this->fld_total_fare->AdvancedSearch->Load();
		$this->fld_booked_driver_id->AdvancedSearch->Load();
		$this->fld_is_approved->AdvancedSearch->Load();
		$this->fld_is_completed->AdvancedSearch->Load();
		$this->fld_is_active->AdvancedSearch->Load();
		$this->fld_created_on->AdvancedSearch->Load();
		$this->fld_dropoff_point->AdvancedSearch->Load();
		$this->fld_estimated_time->AdvancedSearch->Load();
		$this->fld_estimated_fare->AdvancedSearch->Load();
		$this->fld_brn_no->AdvancedSearch->Load();
		$this->fld_journey_type->AdvancedSearch->Load();
		$this->fld_vehicle_type->AdvancedSearch->Load();
		$this->fld_vehicle_mode->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = ew_CurrentUrl();
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tbl_booking_detail_list)) $tbl_booking_detail_list = new ctbl_booking_detail_list();

// Page init
$tbl_booking_detail_list->Page_Init();

// Page main
$tbl_booking_detail_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_booking_detail_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_booking_detail_list = new ew_Page("tbl_booking_detail_list");
tbl_booking_detail_list.PageID = "list"; // Page ID
var EW_PAGE_ID = tbl_booking_detail_list.PageID; // For backward compatibility

// Form object
var ftbl_booking_detaillist = new ew_Form("ftbl_booking_detaillist");
ftbl_booking_detaillist.FormKeyCountName = '<?php echo $tbl_booking_detail_list->FormKeyCountName ?>';

// Form_CustomValidate event
ftbl_booking_detaillist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_booking_detaillist.ValidateRequired = true;
<?php } else { ?>
ftbl_booking_detaillist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftbl_booking_detaillist.Lists["x_fld_booked_driver_id"] = {"LinkField":"x_fld_driver_ai_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_fld_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var ftbl_booking_detaillistsrch = new ew_Form("ftbl_booking_detaillistsrch");

// Validate function for search
ftbl_booking_detaillistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();
	var infix = "";

	// Set up row object
	ew_ElementsToRow(fobj);

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
ftbl_booking_detaillistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_booking_detaillistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
ftbl_booking_detaillistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php if ($tbl_booking_detail_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $tbl_booking_detail_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$tbl_booking_detail_list->TotalRecs = $tbl_booking_detail->SelectRecordCount();
	} else {
		if ($tbl_booking_detail_list->Recordset = $tbl_booking_detail_list->LoadRecordset())
			$tbl_booking_detail_list->TotalRecs = $tbl_booking_detail_list->Recordset->RecordCount();
	}
	$tbl_booking_detail_list->StartRec = 1;
	if ($tbl_booking_detail_list->DisplayRecs <= 0 || ($tbl_booking_detail->Export <> "" && $tbl_booking_detail->ExportAll)) // Display all records
		$tbl_booking_detail_list->DisplayRecs = $tbl_booking_detail_list->TotalRecs;
	if (!($tbl_booking_detail->Export <> "" && $tbl_booking_detail->ExportAll))
		$tbl_booking_detail_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tbl_booking_detail_list->Recordset = $tbl_booking_detail_list->LoadRecordset($tbl_booking_detail_list->StartRec-1, $tbl_booking_detail_list->DisplayRecs);
$tbl_booking_detail_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($tbl_booking_detail->Export == "" && $tbl_booking_detail->CurrentAction == "") { ?>
<form name="ftbl_booking_detaillistsrch" id="ftbl_booking_detaillistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<div class="accordion ewDisplayTable ewSearchTable" id="ftbl_booking_detaillistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#ftbl_booking_detaillistsrch_SearchGroup" href="#ftbl_booking_detaillistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="ftbl_booking_detaillistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="ftbl_booking_detaillistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tbl_booking_detail">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$tbl_booking_detail_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$tbl_booking_detail->RowType = EW_ROWTYPE_SEARCH;

// Render row
$tbl_booking_detail->ResetAttrs();
$tbl_booking_detail_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($tbl_booking_detail->fld_is_approved->Visible) { // fld_is_approved ?>
	<span id="xsc_fld_is_approved" class="ewCell">
		<span class="ewSearchCaption"><?php echo $tbl_booking_detail->fld_is_approved->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_fld_is_approved" id="z_fld_is_approved" value="="></span>
		<span class="control-group ewSearchField">
<div id="tp_x_fld_is_approved" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_approved" id="x_fld_is_approved" value="{value}"<?php echo $tbl_booking_detail->fld_is_approved->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_approved" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_booking_detail->fld_is_approved->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_booking_detail->fld_is_approved->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio"><input type="radio" data-field="x_fld_is_approved" name="x_fld_is_approved" id="x_fld_is_approved_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $tbl_booking_detail->fld_is_approved->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($tbl_booking_detail_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $tbl_booking_detail_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
	</div>
</div>
<div id="xsr_3" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($tbl_booking_detail_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($tbl_booking_detail_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($tbl_booking_detail_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
</div>
</div>
</div>
			</div>
		</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $tbl_booking_detail_list->ShowPageHeader(); ?>
<?php
$tbl_booking_detail_list->ShowMessage();
?>
<table class="ewGrid"><tr><td class="ewGridContent">
<form name="ftbl_booking_detaillist" id="ftbl_booking_detaillist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_booking_detail">
<div id="gmp_tbl_booking_detail" class="ewGridMiddlePanel">
<?php if ($tbl_booking_detail_list->TotalRecs > 0) { ?>
<table id="tbl_tbl_booking_detaillist" class="ewTable ewTableSeparate">
<?php echo $tbl_booking_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$tbl_booking_detail_list->RenderListOptions();

// Render list options (header, left)
$tbl_booking_detail_list->ListOptions->Render("header", "left");
?>
<?php if ($tbl_booking_detail->fld_booking_ai_id->Visible) { // fld_booking_ai_id ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_booking_ai_id) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_booking_ai_id" class="tbl_booking_detail_fld_booking_ai_id"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_booking_ai_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_booking_ai_id) ?>',1);"><div id="elh_tbl_booking_detail_fld_booking_ai_id" class="tbl_booking_detail_fld_booking_ai_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_booking_ai_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_booking_ai_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_booking_ai_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_pickup_point->Visible) { // fld_pickup_point ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_pickup_point) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_pickup_point" class="tbl_booking_detail_fld_pickup_point"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_pickup_point->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_pickup_point) ?>',1);"><div id="elh_tbl_booking_detail_fld_pickup_point" class="tbl_booking_detail_fld_pickup_point">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_pickup_point->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_pickup_point->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_pickup_point->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_customer_name->Visible) { // fld_customer_name ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_customer_name) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_customer_name" class="tbl_booking_detail_fld_customer_name"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_customer_name->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_customer_name) ?>',1);"><div id="elh_tbl_booking_detail_fld_customer_name" class="tbl_booking_detail_fld_customer_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_customer_name->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_customer_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_customer_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_mobile_no->Visible) { // fld_mobile_no ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_mobile_no) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_mobile_no" class="tbl_booking_detail_fld_mobile_no"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_mobile_no->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_mobile_no) ?>',1);"><div id="elh_tbl_booking_detail_fld_mobile_no" class="tbl_booking_detail_fld_mobile_no">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_mobile_no->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_mobile_no->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_mobile_no->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_booking_datetime->Visible) { // fld_booking_datetime ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_booking_datetime) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_booking_datetime" class="tbl_booking_detail_fld_booking_datetime"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_booking_datetime->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_booking_datetime) ?>',1);"><div id="elh_tbl_booking_detail_fld_booking_datetime" class="tbl_booking_detail_fld_booking_datetime">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_booking_datetime->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_booking_datetime->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_booking_datetime->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_coupon_code->Visible) { // fld_coupon_code ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_coupon_code) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_coupon_code" class="tbl_booking_detail_fld_coupon_code"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_coupon_code->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_coupon_code) ?>',1);"><div id="elh_tbl_booking_detail_fld_coupon_code" class="tbl_booking_detail_fld_coupon_code">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_coupon_code->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_coupon_code->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_coupon_code->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_driver_rating->Visible) { // fld_driver_rating ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_driver_rating) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_driver_rating" class="tbl_booking_detail_fld_driver_rating"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_driver_rating->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_driver_rating) ?>',1);"><div id="elh_tbl_booking_detail_fld_driver_rating" class="tbl_booking_detail_fld_driver_rating">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_driver_rating->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_driver_rating->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_driver_rating->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_customer_feedback->Visible) { // fld_customer_feedback ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_customer_feedback) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_customer_feedback" class="tbl_booking_detail_fld_customer_feedback"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_customer_feedback->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_customer_feedback) ?>',1);"><div id="elh_tbl_booking_detail_fld_customer_feedback" class="tbl_booking_detail_fld_customer_feedback">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_customer_feedback->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_customer_feedback->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_customer_feedback->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_is_cancelled->Visible) { // fld_is_cancelled ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_is_cancelled) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_is_cancelled" class="tbl_booking_detail_fld_is_cancelled"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_is_cancelled->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_is_cancelled) ?>',1);"><div id="elh_tbl_booking_detail_fld_is_cancelled" class="tbl_booking_detail_fld_is_cancelled">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_is_cancelled->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_is_cancelled->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_is_cancelled->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_total_fare->Visible) { // fld_total_fare ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_total_fare) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_total_fare" class="tbl_booking_detail_fld_total_fare"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_total_fare->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_total_fare) ?>',1);"><div id="elh_tbl_booking_detail_fld_total_fare" class="tbl_booking_detail_fld_total_fare">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_total_fare->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_total_fare->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_total_fare->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_booked_driver_id->Visible) { // fld_booked_driver_id ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_booked_driver_id) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_booked_driver_id" class="tbl_booking_detail_fld_booked_driver_id"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_booked_driver_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_booked_driver_id) ?>',1);"><div id="elh_tbl_booking_detail_fld_booked_driver_id" class="tbl_booking_detail_fld_booked_driver_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_booked_driver_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_booked_driver_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_booked_driver_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_is_approved->Visible) { // fld_is_approved ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_is_approved) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_is_approved" class="tbl_booking_detail_fld_is_approved"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_is_approved->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_is_approved) ?>',1);"><div id="elh_tbl_booking_detail_fld_is_approved" class="tbl_booking_detail_fld_is_approved">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_is_approved->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_is_approved->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_is_approved->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_is_completed->Visible) { // fld_is_completed ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_is_completed) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_is_completed" class="tbl_booking_detail_fld_is_completed"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_is_completed->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_is_completed) ?>',1);"><div id="elh_tbl_booking_detail_fld_is_completed" class="tbl_booking_detail_fld_is_completed">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_is_completed->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_is_completed->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_is_completed->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_is_active->Visible) { // fld_is_active ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_is_active) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_is_active" class="tbl_booking_detail_fld_is_active"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_is_active->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_is_active) ?>',1);"><div id="elh_tbl_booking_detail_fld_is_active" class="tbl_booking_detail_fld_is_active">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_is_active->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_is_active->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_is_active->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_created_on->Visible) { // fld_created_on ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_created_on) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_created_on" class="tbl_booking_detail_fld_created_on"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_created_on->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_created_on) ?>',1);"><div id="elh_tbl_booking_detail_fld_created_on" class="tbl_booking_detail_fld_created_on">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_created_on->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_created_on->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_created_on->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_dropoff_point->Visible) { // fld_dropoff_point ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_dropoff_point) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_dropoff_point" class="tbl_booking_detail_fld_dropoff_point"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_dropoff_point->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_dropoff_point) ?>',1);"><div id="elh_tbl_booking_detail_fld_dropoff_point" class="tbl_booking_detail_fld_dropoff_point">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_dropoff_point->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_dropoff_point->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_dropoff_point->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_estimated_time->Visible) { // fld_estimated_time ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_estimated_time) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_estimated_time" class="tbl_booking_detail_fld_estimated_time"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_estimated_time->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_estimated_time) ?>',1);"><div id="elh_tbl_booking_detail_fld_estimated_time" class="tbl_booking_detail_fld_estimated_time">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_estimated_time->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_estimated_time->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_estimated_time->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_estimated_fare->Visible) { // fld_estimated_fare ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_estimated_fare) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_estimated_fare" class="tbl_booking_detail_fld_estimated_fare"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_estimated_fare->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_estimated_fare) ?>',1);"><div id="elh_tbl_booking_detail_fld_estimated_fare" class="tbl_booking_detail_fld_estimated_fare">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_estimated_fare->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_estimated_fare->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_estimated_fare->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_brn_no->Visible) { // fld_brn_no ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_brn_no) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_brn_no" class="tbl_booking_detail_fld_brn_no"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_brn_no->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_brn_no) ?>',1);"><div id="elh_tbl_booking_detail_fld_brn_no" class="tbl_booking_detail_fld_brn_no">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_brn_no->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_brn_no->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_brn_no->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_journey_type->Visible) { // fld_journey_type ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_journey_type) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_journey_type" class="tbl_booking_detail_fld_journey_type"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_journey_type->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_journey_type) ?>',1);"><div id="elh_tbl_booking_detail_fld_journey_type" class="tbl_booking_detail_fld_journey_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_journey_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_journey_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_journey_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_vehicle_type->Visible) { // fld_vehicle_type ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_vehicle_type) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_vehicle_type" class="tbl_booking_detail_fld_vehicle_type"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_vehicle_type->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_vehicle_type) ?>',1);"><div id="elh_tbl_booking_detail_fld_vehicle_type" class="tbl_booking_detail_fld_vehicle_type">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_vehicle_type->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_vehicle_type->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_vehicle_type->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_booking_detail->fld_vehicle_mode->Visible) { // fld_vehicle_mode ?>
	<?php if ($tbl_booking_detail->SortUrl($tbl_booking_detail->fld_vehicle_mode) == "") { ?>
		<td><div id="elh_tbl_booking_detail_fld_vehicle_mode" class="tbl_booking_detail_fld_vehicle_mode"><div class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_vehicle_mode->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_booking_detail->SortUrl($tbl_booking_detail->fld_vehicle_mode) ?>',1);"><div id="elh_tbl_booking_detail_fld_vehicle_mode" class="tbl_booking_detail_fld_vehicle_mode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_booking_detail->fld_vehicle_mode->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_booking_detail->fld_vehicle_mode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_booking_detail->fld_vehicle_mode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tbl_booking_detail_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tbl_booking_detail->ExportAll && $tbl_booking_detail->Export <> "") {
	$tbl_booking_detail_list->StopRec = $tbl_booking_detail_list->TotalRecs;
} else {

	// Set the last record to display
	if ($tbl_booking_detail_list->TotalRecs > $tbl_booking_detail_list->StartRec + $tbl_booking_detail_list->DisplayRecs - 1)
		$tbl_booking_detail_list->StopRec = $tbl_booking_detail_list->StartRec + $tbl_booking_detail_list->DisplayRecs - 1;
	else
		$tbl_booking_detail_list->StopRec = $tbl_booking_detail_list->TotalRecs;
}
$tbl_booking_detail_list->RecCnt = $tbl_booking_detail_list->StartRec - 1;
if ($tbl_booking_detail_list->Recordset && !$tbl_booking_detail_list->Recordset->EOF) {
	$tbl_booking_detail_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $tbl_booking_detail_list->StartRec > 1)
		$tbl_booking_detail_list->Recordset->Move($tbl_booking_detail_list->StartRec - 1);
} elseif (!$tbl_booking_detail->AllowAddDeleteRow && $tbl_booking_detail_list->StopRec == 0) {
	$tbl_booking_detail_list->StopRec = $tbl_booking_detail->GridAddRowCount;
}

// Initialize aggregate
$tbl_booking_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tbl_booking_detail->ResetAttrs();
$tbl_booking_detail_list->RenderRow();
while ($tbl_booking_detail_list->RecCnt < $tbl_booking_detail_list->StopRec) {
	$tbl_booking_detail_list->RecCnt++;
	if (intval($tbl_booking_detail_list->RecCnt) >= intval($tbl_booking_detail_list->StartRec)) {
		$tbl_booking_detail_list->RowCnt++;

		// Set up key count
		$tbl_booking_detail_list->KeyCount = $tbl_booking_detail_list->RowIndex;

		// Init row class and style
		$tbl_booking_detail->ResetAttrs();
		$tbl_booking_detail->CssClass = "";
		if ($tbl_booking_detail->CurrentAction == "gridadd") {
		} else {
			$tbl_booking_detail_list->LoadRowValues($tbl_booking_detail_list->Recordset); // Load row values
		}
		$tbl_booking_detail->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$tbl_booking_detail->RowAttrs = array_merge($tbl_booking_detail->RowAttrs, array('data-rowindex'=>$tbl_booking_detail_list->RowCnt, 'id'=>'r' . $tbl_booking_detail_list->RowCnt . '_tbl_booking_detail', 'data-rowtype'=>$tbl_booking_detail->RowType));

		// Render row
		$tbl_booking_detail_list->RenderRow();

		// Render list options
		$tbl_booking_detail_list->RenderListOptions();
?>
	<tr<?php echo $tbl_booking_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tbl_booking_detail_list->ListOptions->Render("body", "left", $tbl_booking_detail_list->RowCnt);
?>
	<?php if ($tbl_booking_detail->fld_booking_ai_id->Visible) { // fld_booking_ai_id ?>
		<td<?php echo $tbl_booking_detail->fld_booking_ai_id->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_booking_ai_id->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_booking_ai_id->ListViewValue() ?></span>
<a id="<?php echo $tbl_booking_detail_list->PageObjName . "_row_" . $tbl_booking_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_pickup_point->Visible) { // fld_pickup_point ?>
		<td<?php echo $tbl_booking_detail->fld_pickup_point->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_pickup_point->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_pickup_point->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_customer_name->Visible) { // fld_customer_name ?>
		<td<?php echo $tbl_booking_detail->fld_customer_name->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_customer_name->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_customer_name->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_mobile_no->Visible) { // fld_mobile_no ?>
		<td<?php echo $tbl_booking_detail->fld_mobile_no->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_mobile_no->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_mobile_no->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_booking_datetime->Visible) { // fld_booking_datetime ?>
		<td<?php echo $tbl_booking_detail->fld_booking_datetime->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_booking_datetime->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_booking_datetime->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_coupon_code->Visible) { // fld_coupon_code ?>
		<td<?php echo $tbl_booking_detail->fld_coupon_code->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_coupon_code->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_coupon_code->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_driver_rating->Visible) { // fld_driver_rating ?>
		<td<?php echo $tbl_booking_detail->fld_driver_rating->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_driver_rating->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_driver_rating->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_customer_feedback->Visible) { // fld_customer_feedback ?>
		<td<?php echo $tbl_booking_detail->fld_customer_feedback->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_customer_feedback->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_customer_feedback->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_is_cancelled->Visible) { // fld_is_cancelled ?>
		<td<?php echo $tbl_booking_detail->fld_is_cancelled->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_is_cancelled->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_is_cancelled->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_total_fare->Visible) { // fld_total_fare ?>
		<td<?php echo $tbl_booking_detail->fld_total_fare->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_total_fare->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_total_fare->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_booked_driver_id->Visible) { // fld_booked_driver_id ?>
		<td<?php echo $tbl_booking_detail->fld_booked_driver_id->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_booked_driver_id->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_booked_driver_id->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_is_approved->Visible) { // fld_is_approved ?>
		<td<?php echo $tbl_booking_detail->fld_is_approved->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_is_approved->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_is_approved->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_is_completed->Visible) { // fld_is_completed ?>
		<td<?php echo $tbl_booking_detail->fld_is_completed->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_is_completed->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_is_completed->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_is_active->Visible) { // fld_is_active ?>
		<td<?php echo $tbl_booking_detail->fld_is_active->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_is_active->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_is_active->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_created_on->Visible) { // fld_created_on ?>
		<td<?php echo $tbl_booking_detail->fld_created_on->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_created_on->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_created_on->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_dropoff_point->Visible) { // fld_dropoff_point ?>
		<td<?php echo $tbl_booking_detail->fld_dropoff_point->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_dropoff_point->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_dropoff_point->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_estimated_time->Visible) { // fld_estimated_time ?>
		<td<?php echo $tbl_booking_detail->fld_estimated_time->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_estimated_time->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_estimated_time->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_estimated_fare->Visible) { // fld_estimated_fare ?>
		<td<?php echo $tbl_booking_detail->fld_estimated_fare->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_estimated_fare->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_estimated_fare->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_brn_no->Visible) { // fld_brn_no ?>
		<td<?php echo $tbl_booking_detail->fld_brn_no->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_brn_no->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_brn_no->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_journey_type->Visible) { // fld_journey_type ?>
		<td<?php echo $tbl_booking_detail->fld_journey_type->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_journey_type->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_journey_type->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_vehicle_type->Visible) { // fld_vehicle_type ?>
		<td<?php echo $tbl_booking_detail->fld_vehicle_type->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_vehicle_type->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_vehicle_type->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_booking_detail->fld_vehicle_mode->Visible) { // fld_vehicle_mode ?>
		<td<?php echo $tbl_booking_detail->fld_vehicle_mode->CellAttributes() ?>>
<span<?php echo $tbl_booking_detail->fld_vehicle_mode->ViewAttributes() ?>>
<?php echo $tbl_booking_detail->fld_vehicle_mode->ListViewValue() ?></span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tbl_booking_detail_list->ListOptions->Render("body", "right", $tbl_booking_detail_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($tbl_booking_detail->CurrentAction <> "gridadd")
		$tbl_booking_detail_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($tbl_booking_detail->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($tbl_booking_detail_list->Recordset)
	$tbl_booking_detail_list->Recordset->Close();
?>
<div class="ewGridLowerPanel">
<?php if ($tbl_booking_detail->CurrentAction <> "gridadd" && $tbl_booking_detail->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($tbl_booking_detail_list->Pager)) $tbl_booking_detail_list->Pager = new cPrevNextPager($tbl_booking_detail_list->StartRec, $tbl_booking_detail_list->DisplayRecs, $tbl_booking_detail_list->TotalRecs) ?>
<?php if ($tbl_booking_detail_list->Pager->RecordCount > 0) { ?>
<table class="ewStdTable"><tbody><tr><td>
	<?php echo $Language->Phrase("Page") ?>&nbsp;
<div class="input-prepend input-append">
<!--first page button-->
	<?php if ($tbl_booking_detail_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $tbl_booking_detail_list->PageUrl() ?>start=<?php echo $tbl_booking_detail_list->Pager->FirstButton->Start ?>"><i class="icon-step-backward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-step-backward"></i></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($tbl_booking_detail_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $tbl_booking_detail_list->PageUrl() ?>start=<?php echo $tbl_booking_detail_list->Pager->PrevButton->Start ?>"><i class="icon-prev"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-prev"></i></a>
	<?php } ?>
<!--current page number-->
	<input class="input-mini" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tbl_booking_detail_list->Pager->CurrentPage ?>">
<!--next page button-->
	<?php if ($tbl_booking_detail_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $tbl_booking_detail_list->PageUrl() ?>start=<?php echo $tbl_booking_detail_list->Pager->NextButton->Start ?>"><i class="icon-play"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-play"></i></a>
	<?php } ?>
<!--last page button-->
	<?php if ($tbl_booking_detail_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $tbl_booking_detail_list->PageUrl() ?>start=<?php echo $tbl_booking_detail_list->Pager->LastButton->Start ?>"><i class="icon-step-forward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-step-forward"></i></a>
	<?php } ?>
</div>
	&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tbl_booking_detail_list->Pager->PageCount ?>
</td>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tbl_booking_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tbl_booking_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tbl_booking_detail_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($tbl_booking_detail_list->SearchWhere == "0=101") { ?>
	<p><?php echo $Language->Phrase("EnterSearchCriteria") ?></p>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoRecord") ?></p>
	<?php } ?>
	<?php } else { ?>
	<p><?php echo $Language->Phrase("NoPermission") ?></p>
	<?php } ?>
<?php } ?>
</td>
</tr></table>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tbl_booking_detail_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
</td></tr></table>
<script type="text/javascript">
ftbl_booking_detaillistsrch.Init();
ftbl_booking_detaillist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_booking_detail_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_booking_detail_list->Page_Terminate();
?>
