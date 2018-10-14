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

$tbl_fare_chart_list = NULL; // Initialize page object first

class ctbl_fare_chart_list extends ctbl_fare_chart {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}";

	// Table name
	var $TableName = 'tbl_fare_chart';

	// Page object name
	var $PageObjName = 'tbl_fare_chart_list';

	// Grid form hidden field names
	var $FormName = 'ftbl_fare_chartlist';
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

		// Table object (tbl_fare_chart)
		if (!isset($GLOBALS["tbl_fare_chart"]) || get_class($GLOBALS["tbl_fare_chart"]) == "ctbl_fare_chart") {
			$GLOBALS["tbl_fare_chart"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_fare_chart"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tbl_fare_chartadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tbl_fare_chartdelete.php";
		$this->MultiUpdateUrl = "tbl_fare_chartupdate.php";

		// Table object (tbl_admin)
		if (!isset($GLOBALS['tbl_admin'])) $GLOBALS['tbl_admin'] = new ctbl_admin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_fare_chart', TRUE);

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
		$this->fld_city_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->fld_city_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->fld_city_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->fld_city_id, FALSE); // fld_city_id
		$this->BuildSearchSql($sWhere, $this->fld_city_name, FALSE); // fld_city_name
		$this->BuildSearchSql($sWhere, $this->fld_city_lat, FALSE); // fld_city_lat
		$this->BuildSearchSql($sWhere, $this->fld_city_lng, FALSE); // fld_city_lng
		$this->BuildSearchSql($sWhere, $this->fld_base_fare, FALSE); // fld_base_fare
		$this->BuildSearchSql($sWhere, $this->fld_fare, FALSE); // fld_fare
		$this->BuildSearchSql($sWhere, $this->fld_night_charge, FALSE); // fld_night_charge
		$this->BuildSearchSql($sWhere, $this->fld_return_charge, FALSE); // fld_return_charge
		$this->BuildSearchSql($sWhere, $this->fld_outstation_base_fare, FALSE); // fld_outstation_base_fare
		$this->BuildSearchSql($sWhere, $this->fld_outstation_fare, FALSE); // fld_outstation_fare
		$this->BuildSearchSql($sWhere, $this->fld_is_active, FALSE); // fld_is_active
		$this->BuildSearchSql($sWhere, $this->fld_created_on, FALSE); // fld_created_on

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->fld_city_id->AdvancedSearch->Save(); // fld_city_id
			$this->fld_city_name->AdvancedSearch->Save(); // fld_city_name
			$this->fld_city_lat->AdvancedSearch->Save(); // fld_city_lat
			$this->fld_city_lng->AdvancedSearch->Save(); // fld_city_lng
			$this->fld_base_fare->AdvancedSearch->Save(); // fld_base_fare
			$this->fld_fare->AdvancedSearch->Save(); // fld_fare
			$this->fld_night_charge->AdvancedSearch->Save(); // fld_night_charge
			$this->fld_return_charge->AdvancedSearch->Save(); // fld_return_charge
			$this->fld_outstation_base_fare->AdvancedSearch->Save(); // fld_outstation_base_fare
			$this->fld_outstation_fare->AdvancedSearch->Save(); // fld_outstation_fare
			$this->fld_is_active->AdvancedSearch->Save(); // fld_is_active
			$this->fld_created_on->AdvancedSearch->Save(); // fld_created_on
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
		$this->BuildBasicSearchSQL($sWhere, $this->fld_city_name, $Keyword);
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
		if ($this->fld_city_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_city_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_city_lat->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_city_lng->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_base_fare->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_fare->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_night_charge->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_return_charge->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_outstation_base_fare->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_outstation_fare->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_is_active->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_created_on->AdvancedSearch->IssetSession())
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
		$this->fld_city_id->AdvancedSearch->UnsetSession();
		$this->fld_city_name->AdvancedSearch->UnsetSession();
		$this->fld_city_lat->AdvancedSearch->UnsetSession();
		$this->fld_city_lng->AdvancedSearch->UnsetSession();
		$this->fld_base_fare->AdvancedSearch->UnsetSession();
		$this->fld_fare->AdvancedSearch->UnsetSession();
		$this->fld_night_charge->AdvancedSearch->UnsetSession();
		$this->fld_return_charge->AdvancedSearch->UnsetSession();
		$this->fld_outstation_base_fare->AdvancedSearch->UnsetSession();
		$this->fld_outstation_fare->AdvancedSearch->UnsetSession();
		$this->fld_is_active->AdvancedSearch->UnsetSession();
		$this->fld_created_on->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->fld_city_id->AdvancedSearch->Load();
		$this->fld_city_name->AdvancedSearch->Load();
		$this->fld_city_lat->AdvancedSearch->Load();
		$this->fld_city_lng->AdvancedSearch->Load();
		$this->fld_base_fare->AdvancedSearch->Load();
		$this->fld_fare->AdvancedSearch->Load();
		$this->fld_night_charge->AdvancedSearch->Load();
		$this->fld_return_charge->AdvancedSearch->Load();
		$this->fld_outstation_base_fare->AdvancedSearch->Load();
		$this->fld_outstation_fare->AdvancedSearch->Load();
		$this->fld_is_active->AdvancedSearch->Load();
		$this->fld_created_on->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->fld_city_id); // fld_city_id
			$this->UpdateSort($this->fld_city_name); // fld_city_name
			$this->UpdateSort($this->fld_city_lat); // fld_city_lat
			$this->UpdateSort($this->fld_city_lng); // fld_city_lng
			$this->UpdateSort($this->fld_base_fare); // fld_base_fare
			$this->UpdateSort($this->fld_fare); // fld_fare
			$this->UpdateSort($this->fld_night_charge); // fld_night_charge
			$this->UpdateSort($this->fld_return_charge); // fld_return_charge
			$this->UpdateSort($this->fld_outstation_base_fare); // fld_outstation_base_fare
			$this->UpdateSort($this->fld_outstation_fare); // fld_outstation_fare
			$this->UpdateSort($this->fld_is_active); // fld_is_active
			$this->UpdateSort($this->fld_created_on); // fld_created_on
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
				$this->fld_city_id->setSort("");
				$this->fld_city_name->setSort("");
				$this->fld_city_lat->setSort("");
				$this->fld_city_lng->setSort("");
				$this->fld_base_fare->setSort("");
				$this->fld_fare->setSort("");
				$this->fld_night_charge->setSort("");
				$this->fld_return_charge->setSort("");
				$this->fld_outstation_base_fare->setSort("");
				$this->fld_outstation_fare->setSort("");
				$this->fld_is_active->setSort("");
				$this->fld_created_on->setSort("");
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
		$oListOpt->Body = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->fld_city_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'></label>";
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.ftbl_fare_chartlist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		// fld_city_id

		$this->fld_city_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_city_id"]);
		if ($this->fld_city_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_city_id->AdvancedSearch->SearchOperator = @$_GET["z_fld_city_id"];

		// fld_city_name
		$this->fld_city_name->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_city_name"]);
		if ($this->fld_city_name->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_city_name->AdvancedSearch->SearchOperator = @$_GET["z_fld_city_name"];

		// fld_city_lat
		$this->fld_city_lat->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_city_lat"]);
		if ($this->fld_city_lat->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_city_lat->AdvancedSearch->SearchOperator = @$_GET["z_fld_city_lat"];

		// fld_city_lng
		$this->fld_city_lng->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_city_lng"]);
		if ($this->fld_city_lng->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_city_lng->AdvancedSearch->SearchOperator = @$_GET["z_fld_city_lng"];

		// fld_base_fare
		$this->fld_base_fare->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_base_fare"]);
		if ($this->fld_base_fare->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_base_fare->AdvancedSearch->SearchOperator = @$_GET["z_fld_base_fare"];

		// fld_fare
		$this->fld_fare->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_fare"]);
		if ($this->fld_fare->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_fare->AdvancedSearch->SearchOperator = @$_GET["z_fld_fare"];

		// fld_night_charge
		$this->fld_night_charge->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_night_charge"]);
		if ($this->fld_night_charge->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_night_charge->AdvancedSearch->SearchOperator = @$_GET["z_fld_night_charge"];

		// fld_return_charge
		$this->fld_return_charge->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_return_charge"]);
		if ($this->fld_return_charge->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_return_charge->AdvancedSearch->SearchOperator = @$_GET["z_fld_return_charge"];

		// fld_outstation_base_fare
		$this->fld_outstation_base_fare->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_outstation_base_fare"]);
		if ($this->fld_outstation_base_fare->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_outstation_base_fare->AdvancedSearch->SearchOperator = @$_GET["z_fld_outstation_base_fare"];

		// fld_outstation_fare
		$this->fld_outstation_fare->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_outstation_fare"]);
		if ($this->fld_outstation_fare->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_outstation_fare->AdvancedSearch->SearchOperator = @$_GET["z_fld_outstation_fare"];

		// fld_is_active
		$this->fld_is_active->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_is_active"]);
		if ($this->fld_is_active->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_is_active->AdvancedSearch->SearchOperator = @$_GET["z_fld_is_active"];

		// fld_created_on
		$this->fld_created_on->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_created_on"]);
		if ($this->fld_created_on->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_created_on->AdvancedSearch->SearchOperator = @$_GET["z_fld_created_on"];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

			// fld_city_id
			$this->fld_city_id->LinkCustomAttributes = "";
			$this->fld_city_id->HrefValue = "";
			$this->fld_city_id->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// fld_city_id
			$this->fld_city_id->EditCustomAttributes = "";
			$this->fld_city_id->EditValue = ew_HtmlEncode($this->fld_city_id->AdvancedSearch->SearchValue);
			$this->fld_city_id->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_city_id->FldCaption()));

			// fld_city_name
			$this->fld_city_name->EditCustomAttributes = "";
			$this->fld_city_name->EditValue = ew_HtmlEncode($this->fld_city_name->AdvancedSearch->SearchValue);
			$this->fld_city_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_city_name->FldCaption()));

			// fld_city_lat
			$this->fld_city_lat->EditCustomAttributes = "";
			$this->fld_city_lat->EditValue = ew_HtmlEncode($this->fld_city_lat->AdvancedSearch->SearchValue);
			$this->fld_city_lat->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_city_lat->FldCaption()));

			// fld_city_lng
			$this->fld_city_lng->EditCustomAttributes = "";
			$this->fld_city_lng->EditValue = ew_HtmlEncode($this->fld_city_lng->AdvancedSearch->SearchValue);
			$this->fld_city_lng->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_city_lng->FldCaption()));

			// fld_base_fare
			$this->fld_base_fare->EditCustomAttributes = "";
			$this->fld_base_fare->EditValue = ew_HtmlEncode($this->fld_base_fare->AdvancedSearch->SearchValue);
			$this->fld_base_fare->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_base_fare->FldCaption()));

			// fld_fare
			$this->fld_fare->EditCustomAttributes = "";
			$this->fld_fare->EditValue = ew_HtmlEncode($this->fld_fare->AdvancedSearch->SearchValue);
			$this->fld_fare->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_fare->FldCaption()));

			// fld_night_charge
			$this->fld_night_charge->EditCustomAttributes = "";
			$this->fld_night_charge->EditValue = ew_HtmlEncode($this->fld_night_charge->AdvancedSearch->SearchValue);
			$this->fld_night_charge->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_night_charge->FldCaption()));

			// fld_return_charge
			$this->fld_return_charge->EditCustomAttributes = "";
			$this->fld_return_charge->EditValue = ew_HtmlEncode($this->fld_return_charge->AdvancedSearch->SearchValue);
			$this->fld_return_charge->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_return_charge->FldCaption()));

			// fld_outstation_base_fare
			$this->fld_outstation_base_fare->EditCustomAttributes = "";
			$this->fld_outstation_base_fare->EditValue = ew_HtmlEncode($this->fld_outstation_base_fare->AdvancedSearch->SearchValue);
			$this->fld_outstation_base_fare->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_outstation_base_fare->FldCaption()));

			// fld_outstation_fare
			$this->fld_outstation_fare->EditCustomAttributes = "";
			$this->fld_outstation_fare->EditValue = ew_HtmlEncode($this->fld_outstation_fare->AdvancedSearch->SearchValue);
			$this->fld_outstation_fare->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_outstation_fare->FldCaption()));

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
		$this->fld_city_id->AdvancedSearch->Load();
		$this->fld_city_name->AdvancedSearch->Load();
		$this->fld_city_lat->AdvancedSearch->Load();
		$this->fld_city_lng->AdvancedSearch->Load();
		$this->fld_base_fare->AdvancedSearch->Load();
		$this->fld_fare->AdvancedSearch->Load();
		$this->fld_night_charge->AdvancedSearch->Load();
		$this->fld_return_charge->AdvancedSearch->Load();
		$this->fld_outstation_base_fare->AdvancedSearch->Load();
		$this->fld_outstation_fare->AdvancedSearch->Load();
		$this->fld_is_active->AdvancedSearch->Load();
		$this->fld_created_on->AdvancedSearch->Load();
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
if (!isset($tbl_fare_chart_list)) $tbl_fare_chart_list = new ctbl_fare_chart_list();

// Page init
$tbl_fare_chart_list->Page_Init();

// Page main
$tbl_fare_chart_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_fare_chart_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_fare_chart_list = new ew_Page("tbl_fare_chart_list");
tbl_fare_chart_list.PageID = "list"; // Page ID
var EW_PAGE_ID = tbl_fare_chart_list.PageID; // For backward compatibility

// Form object
var ftbl_fare_chartlist = new ew_Form("ftbl_fare_chartlist");
ftbl_fare_chartlist.FormKeyCountName = '<?php echo $tbl_fare_chart_list->FormKeyCountName ?>';

// Form_CustomValidate event
ftbl_fare_chartlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_fare_chartlist.ValidateRequired = true;
<?php } else { ?>
ftbl_fare_chartlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var ftbl_fare_chartlistsrch = new ew_Form("ftbl_fare_chartlistsrch");

// Validate function for search
ftbl_fare_chartlistsrch.Validate = function(fobj) {
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
ftbl_fare_chartlistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_fare_chartlistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
ftbl_fare_chartlistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php if ($tbl_fare_chart_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $tbl_fare_chart_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$tbl_fare_chart_list->TotalRecs = $tbl_fare_chart->SelectRecordCount();
	} else {
		if ($tbl_fare_chart_list->Recordset = $tbl_fare_chart_list->LoadRecordset())
			$tbl_fare_chart_list->TotalRecs = $tbl_fare_chart_list->Recordset->RecordCount();
	}
	$tbl_fare_chart_list->StartRec = 1;
	if ($tbl_fare_chart_list->DisplayRecs <= 0 || ($tbl_fare_chart->Export <> "" && $tbl_fare_chart->ExportAll)) // Display all records
		$tbl_fare_chart_list->DisplayRecs = $tbl_fare_chart_list->TotalRecs;
	if (!($tbl_fare_chart->Export <> "" && $tbl_fare_chart->ExportAll))
		$tbl_fare_chart_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tbl_fare_chart_list->Recordset = $tbl_fare_chart_list->LoadRecordset($tbl_fare_chart_list->StartRec-1, $tbl_fare_chart_list->DisplayRecs);
$tbl_fare_chart_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($tbl_fare_chart->Export == "" && $tbl_fare_chart->CurrentAction == "") { ?>
<form name="ftbl_fare_chartlistsrch" id="ftbl_fare_chartlistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<div class="accordion ewDisplayTable ewSearchTable" id="ftbl_fare_chartlistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#ftbl_fare_chartlistsrch_SearchGroup" href="#ftbl_fare_chartlistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="ftbl_fare_chartlistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="ftbl_fare_chartlistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tbl_fare_chart">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$tbl_fare_chart_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$tbl_fare_chart->RowType = EW_ROWTYPE_SEARCH;

// Render row
$tbl_fare_chart->ResetAttrs();
$tbl_fare_chart_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($tbl_fare_chart->fld_is_active->Visible) { // fld_is_active ?>
	<span id="xsc_fld_is_active" class="ewCell">
		<span class="ewSearchCaption"><?php echo $tbl_fare_chart->fld_is_active->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_fld_is_active" id="z_fld_is_active" value="="></span>
		<span class="control-group ewSearchField">
<div id="tp_x_fld_is_active" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_active" id="x_fld_is_active" value="{value}"<?php echo $tbl_fare_chart->fld_is_active->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_active" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_fare_chart->fld_is_active->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_fare_chart->fld_is_active->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
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
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($tbl_fare_chart_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $tbl_fare_chart_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
	</div>
</div>
<div id="xsr_3" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($tbl_fare_chart_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($tbl_fare_chart_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($tbl_fare_chart_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
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
<?php $tbl_fare_chart_list->ShowPageHeader(); ?>
<?php
$tbl_fare_chart_list->ShowMessage();
?>
<table class="ewGrid"><tr><td class="ewGridContent">
<form name="ftbl_fare_chartlist" id="ftbl_fare_chartlist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_fare_chart">
<div id="gmp_tbl_fare_chart" class="ewGridMiddlePanel">
<?php if ($tbl_fare_chart_list->TotalRecs > 0) { ?>
<table id="tbl_tbl_fare_chartlist" class="ewTable ewTableSeparate">
<?php echo $tbl_fare_chart->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$tbl_fare_chart_list->RenderListOptions();

// Render list options (header, left)
$tbl_fare_chart_list->ListOptions->Render("header", "left");
?>
<?php if ($tbl_fare_chart->fld_city_id->Visible) { // fld_city_id ?>
	<?php if ($tbl_fare_chart->SortUrl($tbl_fare_chart->fld_city_id) == "") { ?>
		<td><div id="elh_tbl_fare_chart_fld_city_id" class="tbl_fare_chart_fld_city_id"><div class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_city_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_fare_chart->SortUrl($tbl_fare_chart->fld_city_id) ?>',1);"><div id="elh_tbl_fare_chart_fld_city_id" class="tbl_fare_chart_fld_city_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_city_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_fare_chart->fld_city_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_fare_chart->fld_city_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_fare_chart->fld_city_name->Visible) { // fld_city_name ?>
	<?php if ($tbl_fare_chart->SortUrl($tbl_fare_chart->fld_city_name) == "") { ?>
		<td><div id="elh_tbl_fare_chart_fld_city_name" class="tbl_fare_chart_fld_city_name"><div class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_city_name->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_fare_chart->SortUrl($tbl_fare_chart->fld_city_name) ?>',1);"><div id="elh_tbl_fare_chart_fld_city_name" class="tbl_fare_chart_fld_city_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_city_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbl_fare_chart->fld_city_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_fare_chart->fld_city_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_fare_chart->fld_city_lat->Visible) { // fld_city_lat ?>
	<?php if ($tbl_fare_chart->SortUrl($tbl_fare_chart->fld_city_lat) == "") { ?>
		<td><div id="elh_tbl_fare_chart_fld_city_lat" class="tbl_fare_chart_fld_city_lat"><div class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_city_lat->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_fare_chart->SortUrl($tbl_fare_chart->fld_city_lat) ?>',1);"><div id="elh_tbl_fare_chart_fld_city_lat" class="tbl_fare_chart_fld_city_lat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_city_lat->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_fare_chart->fld_city_lat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_fare_chart->fld_city_lat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_fare_chart->fld_city_lng->Visible) { // fld_city_lng ?>
	<?php if ($tbl_fare_chart->SortUrl($tbl_fare_chart->fld_city_lng) == "") { ?>
		<td><div id="elh_tbl_fare_chart_fld_city_lng" class="tbl_fare_chart_fld_city_lng"><div class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_city_lng->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_fare_chart->SortUrl($tbl_fare_chart->fld_city_lng) ?>',1);"><div id="elh_tbl_fare_chart_fld_city_lng" class="tbl_fare_chart_fld_city_lng">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_city_lng->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_fare_chart->fld_city_lng->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_fare_chart->fld_city_lng->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_fare_chart->fld_base_fare->Visible) { // fld_base_fare ?>
	<?php if ($tbl_fare_chart->SortUrl($tbl_fare_chart->fld_base_fare) == "") { ?>
		<td><div id="elh_tbl_fare_chart_fld_base_fare" class="tbl_fare_chart_fld_base_fare"><div class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_base_fare->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_fare_chart->SortUrl($tbl_fare_chart->fld_base_fare) ?>',1);"><div id="elh_tbl_fare_chart_fld_base_fare" class="tbl_fare_chart_fld_base_fare">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_base_fare->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_fare_chart->fld_base_fare->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_fare_chart->fld_base_fare->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_fare_chart->fld_fare->Visible) { // fld_fare ?>
	<?php if ($tbl_fare_chart->SortUrl($tbl_fare_chart->fld_fare) == "") { ?>
		<td><div id="elh_tbl_fare_chart_fld_fare" class="tbl_fare_chart_fld_fare"><div class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_fare->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_fare_chart->SortUrl($tbl_fare_chart->fld_fare) ?>',1);"><div id="elh_tbl_fare_chart_fld_fare" class="tbl_fare_chart_fld_fare">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_fare->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_fare_chart->fld_fare->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_fare_chart->fld_fare->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_fare_chart->fld_night_charge->Visible) { // fld_night_charge ?>
	<?php if ($tbl_fare_chart->SortUrl($tbl_fare_chart->fld_night_charge) == "") { ?>
		<td><div id="elh_tbl_fare_chart_fld_night_charge" class="tbl_fare_chart_fld_night_charge"><div class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_night_charge->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_fare_chart->SortUrl($tbl_fare_chart->fld_night_charge) ?>',1);"><div id="elh_tbl_fare_chart_fld_night_charge" class="tbl_fare_chart_fld_night_charge">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_night_charge->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_fare_chart->fld_night_charge->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_fare_chart->fld_night_charge->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_fare_chart->fld_return_charge->Visible) { // fld_return_charge ?>
	<?php if ($tbl_fare_chart->SortUrl($tbl_fare_chart->fld_return_charge) == "") { ?>
		<td><div id="elh_tbl_fare_chart_fld_return_charge" class="tbl_fare_chart_fld_return_charge"><div class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_return_charge->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_fare_chart->SortUrl($tbl_fare_chart->fld_return_charge) ?>',1);"><div id="elh_tbl_fare_chart_fld_return_charge" class="tbl_fare_chart_fld_return_charge">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_return_charge->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_fare_chart->fld_return_charge->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_fare_chart->fld_return_charge->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_fare_chart->fld_outstation_base_fare->Visible) { // fld_outstation_base_fare ?>
	<?php if ($tbl_fare_chart->SortUrl($tbl_fare_chart->fld_outstation_base_fare) == "") { ?>
		<td><div id="elh_tbl_fare_chart_fld_outstation_base_fare" class="tbl_fare_chart_fld_outstation_base_fare"><div class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_outstation_base_fare->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_fare_chart->SortUrl($tbl_fare_chart->fld_outstation_base_fare) ?>',1);"><div id="elh_tbl_fare_chart_fld_outstation_base_fare" class="tbl_fare_chart_fld_outstation_base_fare">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_outstation_base_fare->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_fare_chart->fld_outstation_base_fare->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_fare_chart->fld_outstation_base_fare->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_fare_chart->fld_outstation_fare->Visible) { // fld_outstation_fare ?>
	<?php if ($tbl_fare_chart->SortUrl($tbl_fare_chart->fld_outstation_fare) == "") { ?>
		<td><div id="elh_tbl_fare_chart_fld_outstation_fare" class="tbl_fare_chart_fld_outstation_fare"><div class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_outstation_fare->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_fare_chart->SortUrl($tbl_fare_chart->fld_outstation_fare) ?>',1);"><div id="elh_tbl_fare_chart_fld_outstation_fare" class="tbl_fare_chart_fld_outstation_fare">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_outstation_fare->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_fare_chart->fld_outstation_fare->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_fare_chart->fld_outstation_fare->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_fare_chart->fld_is_active->Visible) { // fld_is_active ?>
	<?php if ($tbl_fare_chart->SortUrl($tbl_fare_chart->fld_is_active) == "") { ?>
		<td><div id="elh_tbl_fare_chart_fld_is_active" class="tbl_fare_chart_fld_is_active"><div class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_is_active->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_fare_chart->SortUrl($tbl_fare_chart->fld_is_active) ?>',1);"><div id="elh_tbl_fare_chart_fld_is_active" class="tbl_fare_chart_fld_is_active">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_is_active->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_fare_chart->fld_is_active->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_fare_chart->fld_is_active->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_fare_chart->fld_created_on->Visible) { // fld_created_on ?>
	<?php if ($tbl_fare_chart->SortUrl($tbl_fare_chart->fld_created_on) == "") { ?>
		<td><div id="elh_tbl_fare_chart_fld_created_on" class="tbl_fare_chart_fld_created_on"><div class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_created_on->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_fare_chart->SortUrl($tbl_fare_chart->fld_created_on) ?>',1);"><div id="elh_tbl_fare_chart_fld_created_on" class="tbl_fare_chart_fld_created_on">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_fare_chart->fld_created_on->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_fare_chart->fld_created_on->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_fare_chart->fld_created_on->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tbl_fare_chart_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tbl_fare_chart->ExportAll && $tbl_fare_chart->Export <> "") {
	$tbl_fare_chart_list->StopRec = $tbl_fare_chart_list->TotalRecs;
} else {

	// Set the last record to display
	if ($tbl_fare_chart_list->TotalRecs > $tbl_fare_chart_list->StartRec + $tbl_fare_chart_list->DisplayRecs - 1)
		$tbl_fare_chart_list->StopRec = $tbl_fare_chart_list->StartRec + $tbl_fare_chart_list->DisplayRecs - 1;
	else
		$tbl_fare_chart_list->StopRec = $tbl_fare_chart_list->TotalRecs;
}
$tbl_fare_chart_list->RecCnt = $tbl_fare_chart_list->StartRec - 1;
if ($tbl_fare_chart_list->Recordset && !$tbl_fare_chart_list->Recordset->EOF) {
	$tbl_fare_chart_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $tbl_fare_chart_list->StartRec > 1)
		$tbl_fare_chart_list->Recordset->Move($tbl_fare_chart_list->StartRec - 1);
} elseif (!$tbl_fare_chart->AllowAddDeleteRow && $tbl_fare_chart_list->StopRec == 0) {
	$tbl_fare_chart_list->StopRec = $tbl_fare_chart->GridAddRowCount;
}

// Initialize aggregate
$tbl_fare_chart->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tbl_fare_chart->ResetAttrs();
$tbl_fare_chart_list->RenderRow();
while ($tbl_fare_chart_list->RecCnt < $tbl_fare_chart_list->StopRec) {
	$tbl_fare_chart_list->RecCnt++;
	if (intval($tbl_fare_chart_list->RecCnt) >= intval($tbl_fare_chart_list->StartRec)) {
		$tbl_fare_chart_list->RowCnt++;

		// Set up key count
		$tbl_fare_chart_list->KeyCount = $tbl_fare_chart_list->RowIndex;

		// Init row class and style
		$tbl_fare_chart->ResetAttrs();
		$tbl_fare_chart->CssClass = "";
		if ($tbl_fare_chart->CurrentAction == "gridadd") {
		} else {
			$tbl_fare_chart_list->LoadRowValues($tbl_fare_chart_list->Recordset); // Load row values
		}
		$tbl_fare_chart->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$tbl_fare_chart->RowAttrs = array_merge($tbl_fare_chart->RowAttrs, array('data-rowindex'=>$tbl_fare_chart_list->RowCnt, 'id'=>'r' . $tbl_fare_chart_list->RowCnt . '_tbl_fare_chart', 'data-rowtype'=>$tbl_fare_chart->RowType));

		// Render row
		$tbl_fare_chart_list->RenderRow();

		// Render list options
		$tbl_fare_chart_list->RenderListOptions();
?>
	<tr<?php echo $tbl_fare_chart->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tbl_fare_chart_list->ListOptions->Render("body", "left", $tbl_fare_chart_list->RowCnt);
?>
	<?php if ($tbl_fare_chart->fld_city_id->Visible) { // fld_city_id ?>
		<td<?php echo $tbl_fare_chart->fld_city_id->CellAttributes() ?>>
<span<?php echo $tbl_fare_chart->fld_city_id->ViewAttributes() ?>>
<?php echo $tbl_fare_chart->fld_city_id->ListViewValue() ?></span>
<a id="<?php echo $tbl_fare_chart_list->PageObjName . "_row_" . $tbl_fare_chart_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_fare_chart->fld_city_name->Visible) { // fld_city_name ?>
		<td<?php echo $tbl_fare_chart->fld_city_name->CellAttributes() ?>>
<span<?php echo $tbl_fare_chart->fld_city_name->ViewAttributes() ?>>
<?php echo $tbl_fare_chart->fld_city_name->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_fare_chart->fld_city_lat->Visible) { // fld_city_lat ?>
		<td<?php echo $tbl_fare_chart->fld_city_lat->CellAttributes() ?>>
<span<?php echo $tbl_fare_chart->fld_city_lat->ViewAttributes() ?>>
<?php echo $tbl_fare_chart->fld_city_lat->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_fare_chart->fld_city_lng->Visible) { // fld_city_lng ?>
		<td<?php echo $tbl_fare_chart->fld_city_lng->CellAttributes() ?>>
<span<?php echo $tbl_fare_chart->fld_city_lng->ViewAttributes() ?>>
<?php echo $tbl_fare_chart->fld_city_lng->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_fare_chart->fld_base_fare->Visible) { // fld_base_fare ?>
		<td<?php echo $tbl_fare_chart->fld_base_fare->CellAttributes() ?>>
<span<?php echo $tbl_fare_chart->fld_base_fare->ViewAttributes() ?>>
<?php echo $tbl_fare_chart->fld_base_fare->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_fare_chart->fld_fare->Visible) { // fld_fare ?>
		<td<?php echo $tbl_fare_chart->fld_fare->CellAttributes() ?>>
<span<?php echo $tbl_fare_chart->fld_fare->ViewAttributes() ?>>
<?php echo $tbl_fare_chart->fld_fare->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_fare_chart->fld_night_charge->Visible) { // fld_night_charge ?>
		<td<?php echo $tbl_fare_chart->fld_night_charge->CellAttributes() ?>>
<span<?php echo $tbl_fare_chart->fld_night_charge->ViewAttributes() ?>>
<?php echo $tbl_fare_chart->fld_night_charge->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_fare_chart->fld_return_charge->Visible) { // fld_return_charge ?>
		<td<?php echo $tbl_fare_chart->fld_return_charge->CellAttributes() ?>>
<span<?php echo $tbl_fare_chart->fld_return_charge->ViewAttributes() ?>>
<?php echo $tbl_fare_chart->fld_return_charge->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_fare_chart->fld_outstation_base_fare->Visible) { // fld_outstation_base_fare ?>
		<td<?php echo $tbl_fare_chart->fld_outstation_base_fare->CellAttributes() ?>>
<span<?php echo $tbl_fare_chart->fld_outstation_base_fare->ViewAttributes() ?>>
<?php echo $tbl_fare_chart->fld_outstation_base_fare->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_fare_chart->fld_outstation_fare->Visible) { // fld_outstation_fare ?>
		<td<?php echo $tbl_fare_chart->fld_outstation_fare->CellAttributes() ?>>
<span<?php echo $tbl_fare_chart->fld_outstation_fare->ViewAttributes() ?>>
<?php echo $tbl_fare_chart->fld_outstation_fare->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_fare_chart->fld_is_active->Visible) { // fld_is_active ?>
		<td<?php echo $tbl_fare_chart->fld_is_active->CellAttributes() ?>>
<span<?php echo $tbl_fare_chart->fld_is_active->ViewAttributes() ?>>
<?php echo $tbl_fare_chart->fld_is_active->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_fare_chart->fld_created_on->Visible) { // fld_created_on ?>
		<td<?php echo $tbl_fare_chart->fld_created_on->CellAttributes() ?>>
<span<?php echo $tbl_fare_chart->fld_created_on->ViewAttributes() ?>>
<?php echo $tbl_fare_chart->fld_created_on->ListViewValue() ?></span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tbl_fare_chart_list->ListOptions->Render("body", "right", $tbl_fare_chart_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($tbl_fare_chart->CurrentAction <> "gridadd")
		$tbl_fare_chart_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($tbl_fare_chart->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($tbl_fare_chart_list->Recordset)
	$tbl_fare_chart_list->Recordset->Close();
?>
<div class="ewGridLowerPanel">
<?php if ($tbl_fare_chart->CurrentAction <> "gridadd" && $tbl_fare_chart->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($tbl_fare_chart_list->Pager)) $tbl_fare_chart_list->Pager = new cPrevNextPager($tbl_fare_chart_list->StartRec, $tbl_fare_chart_list->DisplayRecs, $tbl_fare_chart_list->TotalRecs) ?>
<?php if ($tbl_fare_chart_list->Pager->RecordCount > 0) { ?>
<table class="ewStdTable"><tbody><tr><td>
	<?php echo $Language->Phrase("Page") ?>&nbsp;
<div class="input-prepend input-append">
<!--first page button-->
	<?php if ($tbl_fare_chart_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $tbl_fare_chart_list->PageUrl() ?>start=<?php echo $tbl_fare_chart_list->Pager->FirstButton->Start ?>"><i class="icon-step-backward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-step-backward"></i></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($tbl_fare_chart_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $tbl_fare_chart_list->PageUrl() ?>start=<?php echo $tbl_fare_chart_list->Pager->PrevButton->Start ?>"><i class="icon-prev"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-prev"></i></a>
	<?php } ?>
<!--current page number-->
	<input class="input-mini" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tbl_fare_chart_list->Pager->CurrentPage ?>">
<!--next page button-->
	<?php if ($tbl_fare_chart_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $tbl_fare_chart_list->PageUrl() ?>start=<?php echo $tbl_fare_chart_list->Pager->NextButton->Start ?>"><i class="icon-play"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-play"></i></a>
	<?php } ?>
<!--last page button-->
	<?php if ($tbl_fare_chart_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $tbl_fare_chart_list->PageUrl() ?>start=<?php echo $tbl_fare_chart_list->Pager->LastButton->Start ?>"><i class="icon-step-forward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-step-forward"></i></a>
	<?php } ?>
</div>
	&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tbl_fare_chart_list->Pager->PageCount ?>
</td>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tbl_fare_chart_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tbl_fare_chart_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tbl_fare_chart_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($tbl_fare_chart_list->SearchWhere == "0=101") { ?>
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
	foreach ($tbl_fare_chart_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
</td></tr></table>
<script type="text/javascript">
ftbl_fare_chartlistsrch.Init();
ftbl_fare_chartlist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_fare_chart_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_fare_chart_list->Page_Terminate();
?>
