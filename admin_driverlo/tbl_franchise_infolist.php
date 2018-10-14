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

$tbl_franchise_info_list = NULL; // Initialize page object first

class ctbl_franchise_info_list extends ctbl_franchise_info {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{EF683EA7-113B-4FD4-A0F1-4B1B7BEBED8D}";

	// Table name
	var $TableName = 'tbl_franchise_info';

	// Page object name
	var $PageObjName = 'tbl_franchise_info_list';

	// Grid form hidden field names
	var $FormName = 'ftbl_franchise_infolist';
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

		// Table object (tbl_franchise_info)
		if (!isset($GLOBALS["tbl_franchise_info"]) || get_class($GLOBALS["tbl_franchise_info"]) == "ctbl_franchise_info") {
			$GLOBALS["tbl_franchise_info"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbl_franchise_info"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tbl_franchise_infoadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tbl_franchise_infodelete.php";
		$this->MultiUpdateUrl = "tbl_franchise_infoupdate.php";

		// Table object (tbl_admin)
		if (!isset($GLOBALS['tbl_admin'])) $GLOBALS['tbl_admin'] = new ctbl_admin();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbl_franchise_info', TRUE);

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
		$this->fld_franchise_ai_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->fld_franchise_ai_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->fld_franchise_ai_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere() {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->fld_franchise_ai_id, FALSE); // fld_franchise_ai_id
		$this->BuildSearchSql($sWhere, $this->fld_name, FALSE); // fld_name
		$this->BuildSearchSql($sWhere, $this->fld_location, FALSE); // fld_location
		$this->BuildSearchSql($sWhere, $this->fld_rating, FALSE); // fld_rating
		$this->BuildSearchSql($sWhere, $this->fld_is_active, FALSE); // fld_is_active
		$this->BuildSearchSql($sWhere, $this->fld_created_on, FALSE); // fld_created_on

		// Set up search parm
		if ($sWhere <> "") {
			$this->Command = "search";
		}
		if ($this->Command == "search") {
			$this->fld_franchise_ai_id->AdvancedSearch->Save(); // fld_franchise_ai_id
			$this->fld_name->AdvancedSearch->Save(); // fld_name
			$this->fld_location->AdvancedSearch->Save(); // fld_location
			$this->fld_rating->AdvancedSearch->Save(); // fld_rating
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
		$this->BuildBasicSearchSQL($sWhere, $this->fld_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->fld_location, $Keyword);
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
		if ($this->fld_franchise_ai_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_name->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_location->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->fld_rating->AdvancedSearch->IssetSession())
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
		$this->fld_franchise_ai_id->AdvancedSearch->UnsetSession();
		$this->fld_name->AdvancedSearch->UnsetSession();
		$this->fld_location->AdvancedSearch->UnsetSession();
		$this->fld_rating->AdvancedSearch->UnsetSession();
		$this->fld_is_active->AdvancedSearch->UnsetSession();
		$this->fld_created_on->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->fld_franchise_ai_id->AdvancedSearch->Load();
		$this->fld_name->AdvancedSearch->Load();
		$this->fld_location->AdvancedSearch->Load();
		$this->fld_rating->AdvancedSearch->Load();
		$this->fld_is_active->AdvancedSearch->Load();
		$this->fld_created_on->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->fld_franchise_ai_id); // fld_franchise_ai_id
			$this->UpdateSort($this->fld_name); // fld_name
			$this->UpdateSort($this->fld_location); // fld_location
			$this->UpdateSort($this->fld_rating); // fld_rating
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
				$this->fld_franchise_ai_id->setSort("");
				$this->fld_name->setSort("");
				$this->fld_location->setSort("");
				$this->fld_rating->setSort("");
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
		$oListOpt->Body = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->fld_franchise_ai_id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'></label>";
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
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.ftbl_franchise_infolist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
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
		// fld_franchise_ai_id

		$this->fld_franchise_ai_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_franchise_ai_id"]);
		if ($this->fld_franchise_ai_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_franchise_ai_id->AdvancedSearch->SearchOperator = @$_GET["z_fld_franchise_ai_id"];

		// fld_name
		$this->fld_name->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_name"]);
		if ($this->fld_name->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_name->AdvancedSearch->SearchOperator = @$_GET["z_fld_name"];

		// fld_location
		$this->fld_location->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_location"]);
		if ($this->fld_location->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_location->AdvancedSearch->SearchOperator = @$_GET["z_fld_location"];

		// fld_rating
		$this->fld_rating->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_fld_rating"]);
		if ($this->fld_rating->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->fld_rating->AdvancedSearch->SearchOperator = @$_GET["z_fld_rating"];

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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

			// fld_franchise_ai_id
			$this->fld_franchise_ai_id->LinkCustomAttributes = "";
			$this->fld_franchise_ai_id->HrefValue = "";
			$this->fld_franchise_ai_id->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// fld_franchise_ai_id
			$this->fld_franchise_ai_id->EditCustomAttributes = "";
			$this->fld_franchise_ai_id->EditValue = ew_HtmlEncode($this->fld_franchise_ai_id->AdvancedSearch->SearchValue);
			$this->fld_franchise_ai_id->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_franchise_ai_id->FldCaption()));

			// fld_name
			$this->fld_name->EditCustomAttributes = "";
			$this->fld_name->EditValue = ew_HtmlEncode($this->fld_name->AdvancedSearch->SearchValue);
			$this->fld_name->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_name->FldCaption()));

			// fld_location
			$this->fld_location->EditCustomAttributes = "";
			$this->fld_location->EditValue = ew_HtmlEncode($this->fld_location->AdvancedSearch->SearchValue);
			$this->fld_location->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_location->FldCaption()));

			// fld_rating
			$this->fld_rating->EditCustomAttributes = "";
			$this->fld_rating->EditValue = ew_HtmlEncode($this->fld_rating->AdvancedSearch->SearchValue);
			$this->fld_rating->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fld_rating->FldCaption()));

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
		$this->fld_franchise_ai_id->AdvancedSearch->Load();
		$this->fld_name->AdvancedSearch->Load();
		$this->fld_location->AdvancedSearch->Load();
		$this->fld_rating->AdvancedSearch->Load();
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
if (!isset($tbl_franchise_info_list)) $tbl_franchise_info_list = new ctbl_franchise_info_list();

// Page init
$tbl_franchise_info_list->Page_Init();

// Page main
$tbl_franchise_info_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbl_franchise_info_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var tbl_franchise_info_list = new ew_Page("tbl_franchise_info_list");
tbl_franchise_info_list.PageID = "list"; // Page ID
var EW_PAGE_ID = tbl_franchise_info_list.PageID; // For backward compatibility

// Form object
var ftbl_franchise_infolist = new ew_Form("ftbl_franchise_infolist");
ftbl_franchise_infolist.FormKeyCountName = '<?php echo $tbl_franchise_info_list->FormKeyCountName ?>';

// Form_CustomValidate event
ftbl_franchise_infolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_franchise_infolist.ValidateRequired = true;
<?php } else { ?>
ftbl_franchise_infolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var ftbl_franchise_infolistsrch = new ew_Form("ftbl_franchise_infolistsrch");

// Validate function for search
ftbl_franchise_infolistsrch.Validate = function(fobj) {
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
ftbl_franchise_infolistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbl_franchise_infolistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
ftbl_franchise_infolistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php if ($tbl_franchise_info_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $tbl_franchise_info_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$tbl_franchise_info_list->TotalRecs = $tbl_franchise_info->SelectRecordCount();
	} else {
		if ($tbl_franchise_info_list->Recordset = $tbl_franchise_info_list->LoadRecordset())
			$tbl_franchise_info_list->TotalRecs = $tbl_franchise_info_list->Recordset->RecordCount();
	}
	$tbl_franchise_info_list->StartRec = 1;
	if ($tbl_franchise_info_list->DisplayRecs <= 0 || ($tbl_franchise_info->Export <> "" && $tbl_franchise_info->ExportAll)) // Display all records
		$tbl_franchise_info_list->DisplayRecs = $tbl_franchise_info_list->TotalRecs;
	if (!($tbl_franchise_info->Export <> "" && $tbl_franchise_info->ExportAll))
		$tbl_franchise_info_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tbl_franchise_info_list->Recordset = $tbl_franchise_info_list->LoadRecordset($tbl_franchise_info_list->StartRec-1, $tbl_franchise_info_list->DisplayRecs);
$tbl_franchise_info_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($tbl_franchise_info->Export == "" && $tbl_franchise_info->CurrentAction == "") { ?>
<form name="ftbl_franchise_infolistsrch" id="ftbl_franchise_infolistsrch" class="ewForm form-inline" action="<?php echo ew_CurrentPage() ?>">
<div class="accordion ewDisplayTable ewSearchTable" id="ftbl_franchise_infolistsrch_SearchGroup">
	<div class="accordion-group">
		<div class="accordion-heading">
<a class="accordion-toggle" data-toggle="collapse" data-parent="#ftbl_franchise_infolistsrch_SearchGroup" href="#ftbl_franchise_infolistsrch_SearchBody"><?php echo $Language->Phrase("Search") ?></a>
		</div>
		<div id="ftbl_franchise_infolistsrch_SearchBody" class="accordion-body collapse in">
			<div class="accordion-inner">
<div id="ftbl_franchise_infolistsrch_SearchPanel">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tbl_franchise_info">
<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$tbl_franchise_info_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$tbl_franchise_info->RowType = EW_ROWTYPE_SEARCH;

// Render row
$tbl_franchise_info->ResetAttrs();
$tbl_franchise_info_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($tbl_franchise_info->fld_is_active->Visible) { // fld_is_active ?>
	<span id="xsc_fld_is_active" class="ewCell">
		<span class="ewSearchCaption"><?php echo $tbl_franchise_info->fld_is_active->FldCaption() ?></span>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_fld_is_active" id="z_fld_is_active" value="="></span>
		<span class="control-group ewSearchField">
<div id="tp_x_fld_is_active" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_fld_is_active" id="x_fld_is_active" value="{value}"<?php echo $tbl_franchise_info->fld_is_active->EditAttributes() ?>></div>
<div id="dsl_x_fld_is_active" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $tbl_franchise_info->fld_is_active->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tbl_franchise_info->fld_is_active->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
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
	</span>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="btn-group ewButtonGroup">
	<div class="input-append">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="input-large" value="<?php echo ew_HtmlEncode($tbl_franchise_info_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo $Language->Phrase("Search") ?>">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
	<div class="btn-group ewButtonGroup">
	<a class="btn ewShowAll" href="<?php echo $tbl_franchise_info_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>
	</div>
</div>
<div id="xsr_3" class="ewRow">
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($tbl_franchise_info_list->BasicSearch->getType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($tbl_franchise_info_list->BasicSearch->getType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>
	<label class="inline radio ewRadio" style="white-space: nowrap;"><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($tbl_franchise_info_list->BasicSearch->getType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
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
<?php $tbl_franchise_info_list->ShowPageHeader(); ?>
<?php
$tbl_franchise_info_list->ShowMessage();
?>
<table class="ewGrid"><tr><td class="ewGridContent">
<form name="ftbl_franchise_infolist" id="ftbl_franchise_infolist" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="tbl_franchise_info">
<div id="gmp_tbl_franchise_info" class="ewGridMiddlePanel">
<?php if ($tbl_franchise_info_list->TotalRecs > 0) { ?>
<table id="tbl_tbl_franchise_infolist" class="ewTable ewTableSeparate">
<?php echo $tbl_franchise_info->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$tbl_franchise_info_list->RenderListOptions();

// Render list options (header, left)
$tbl_franchise_info_list->ListOptions->Render("header", "left");
?>
<?php if ($tbl_franchise_info->fld_franchise_ai_id->Visible) { // fld_franchise_ai_id ?>
	<?php if ($tbl_franchise_info->SortUrl($tbl_franchise_info->fld_franchise_ai_id) == "") { ?>
		<td><div id="elh_tbl_franchise_info_fld_franchise_ai_id" class="tbl_franchise_info_fld_franchise_ai_id"><div class="ewTableHeaderCaption"><?php echo $tbl_franchise_info->fld_franchise_ai_id->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_franchise_info->SortUrl($tbl_franchise_info->fld_franchise_ai_id) ?>',1);"><div id="elh_tbl_franchise_info_fld_franchise_ai_id" class="tbl_franchise_info_fld_franchise_ai_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_franchise_info->fld_franchise_ai_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_franchise_info->fld_franchise_ai_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_franchise_info->fld_franchise_ai_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_franchise_info->fld_name->Visible) { // fld_name ?>
	<?php if ($tbl_franchise_info->SortUrl($tbl_franchise_info->fld_name) == "") { ?>
		<td><div id="elh_tbl_franchise_info_fld_name" class="tbl_franchise_info_fld_name"><div class="ewTableHeaderCaption"><?php echo $tbl_franchise_info->fld_name->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_franchise_info->SortUrl($tbl_franchise_info->fld_name) ?>',1);"><div id="elh_tbl_franchise_info_fld_name" class="tbl_franchise_info_fld_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_franchise_info->fld_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbl_franchise_info->fld_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_franchise_info->fld_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_franchise_info->fld_location->Visible) { // fld_location ?>
	<?php if ($tbl_franchise_info->SortUrl($tbl_franchise_info->fld_location) == "") { ?>
		<td><div id="elh_tbl_franchise_info_fld_location" class="tbl_franchise_info_fld_location"><div class="ewTableHeaderCaption"><?php echo $tbl_franchise_info->fld_location->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_franchise_info->SortUrl($tbl_franchise_info->fld_location) ?>',1);"><div id="elh_tbl_franchise_info_fld_location" class="tbl_franchise_info_fld_location">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_franchise_info->fld_location->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbl_franchise_info->fld_location->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_franchise_info->fld_location->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_franchise_info->fld_rating->Visible) { // fld_rating ?>
	<?php if ($tbl_franchise_info->SortUrl($tbl_franchise_info->fld_rating) == "") { ?>
		<td><div id="elh_tbl_franchise_info_fld_rating" class="tbl_franchise_info_fld_rating"><div class="ewTableHeaderCaption"><?php echo $tbl_franchise_info->fld_rating->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_franchise_info->SortUrl($tbl_franchise_info->fld_rating) ?>',1);"><div id="elh_tbl_franchise_info_fld_rating" class="tbl_franchise_info_fld_rating">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_franchise_info->fld_rating->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_franchise_info->fld_rating->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_franchise_info->fld_rating->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_franchise_info->fld_is_active->Visible) { // fld_is_active ?>
	<?php if ($tbl_franchise_info->SortUrl($tbl_franchise_info->fld_is_active) == "") { ?>
		<td><div id="elh_tbl_franchise_info_fld_is_active" class="tbl_franchise_info_fld_is_active"><div class="ewTableHeaderCaption"><?php echo $tbl_franchise_info->fld_is_active->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_franchise_info->SortUrl($tbl_franchise_info->fld_is_active) ?>',1);"><div id="elh_tbl_franchise_info_fld_is_active" class="tbl_franchise_info_fld_is_active">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_franchise_info->fld_is_active->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_franchise_info->fld_is_active->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_franchise_info->fld_is_active->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php if ($tbl_franchise_info->fld_created_on->Visible) { // fld_created_on ?>
	<?php if ($tbl_franchise_info->SortUrl($tbl_franchise_info->fld_created_on) == "") { ?>
		<td><div id="elh_tbl_franchise_info_fld_created_on" class="tbl_franchise_info_fld_created_on"><div class="ewTableHeaderCaption"><?php echo $tbl_franchise_info->fld_created_on->FldCaption() ?></div></div></td>
	<?php } else { ?>
		<td><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbl_franchise_info->SortUrl($tbl_franchise_info->fld_created_on) ?>',1);"><div id="elh_tbl_franchise_info_fld_created_on" class="tbl_franchise_info_fld_created_on">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbl_franchise_info->fld_created_on->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbl_franchise_info->fld_created_on->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tbl_franchise_info->fld_created_on->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></td>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tbl_franchise_info_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tbl_franchise_info->ExportAll && $tbl_franchise_info->Export <> "") {
	$tbl_franchise_info_list->StopRec = $tbl_franchise_info_list->TotalRecs;
} else {

	// Set the last record to display
	if ($tbl_franchise_info_list->TotalRecs > $tbl_franchise_info_list->StartRec + $tbl_franchise_info_list->DisplayRecs - 1)
		$tbl_franchise_info_list->StopRec = $tbl_franchise_info_list->StartRec + $tbl_franchise_info_list->DisplayRecs - 1;
	else
		$tbl_franchise_info_list->StopRec = $tbl_franchise_info_list->TotalRecs;
}
$tbl_franchise_info_list->RecCnt = $tbl_franchise_info_list->StartRec - 1;
if ($tbl_franchise_info_list->Recordset && !$tbl_franchise_info_list->Recordset->EOF) {
	$tbl_franchise_info_list->Recordset->MoveFirst();
	if (!$bSelectLimit && $tbl_franchise_info_list->StartRec > 1)
		$tbl_franchise_info_list->Recordset->Move($tbl_franchise_info_list->StartRec - 1);
} elseif (!$tbl_franchise_info->AllowAddDeleteRow && $tbl_franchise_info_list->StopRec == 0) {
	$tbl_franchise_info_list->StopRec = $tbl_franchise_info->GridAddRowCount;
}

// Initialize aggregate
$tbl_franchise_info->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tbl_franchise_info->ResetAttrs();
$tbl_franchise_info_list->RenderRow();
while ($tbl_franchise_info_list->RecCnt < $tbl_franchise_info_list->StopRec) {
	$tbl_franchise_info_list->RecCnt++;
	if (intval($tbl_franchise_info_list->RecCnt) >= intval($tbl_franchise_info_list->StartRec)) {
		$tbl_franchise_info_list->RowCnt++;

		// Set up key count
		$tbl_franchise_info_list->KeyCount = $tbl_franchise_info_list->RowIndex;

		// Init row class and style
		$tbl_franchise_info->ResetAttrs();
		$tbl_franchise_info->CssClass = "";
		if ($tbl_franchise_info->CurrentAction == "gridadd") {
		} else {
			$tbl_franchise_info_list->LoadRowValues($tbl_franchise_info_list->Recordset); // Load row values
		}
		$tbl_franchise_info->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$tbl_franchise_info->RowAttrs = array_merge($tbl_franchise_info->RowAttrs, array('data-rowindex'=>$tbl_franchise_info_list->RowCnt, 'id'=>'r' . $tbl_franchise_info_list->RowCnt . '_tbl_franchise_info', 'data-rowtype'=>$tbl_franchise_info->RowType));

		// Render row
		$tbl_franchise_info_list->RenderRow();

		// Render list options
		$tbl_franchise_info_list->RenderListOptions();
?>
	<tr<?php echo $tbl_franchise_info->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tbl_franchise_info_list->ListOptions->Render("body", "left", $tbl_franchise_info_list->RowCnt);
?>
	<?php if ($tbl_franchise_info->fld_franchise_ai_id->Visible) { // fld_franchise_ai_id ?>
		<td<?php echo $tbl_franchise_info->fld_franchise_ai_id->CellAttributes() ?>>
<span<?php echo $tbl_franchise_info->fld_franchise_ai_id->ViewAttributes() ?>>
<?php echo $tbl_franchise_info->fld_franchise_ai_id->ListViewValue() ?></span>
<a id="<?php echo $tbl_franchise_info_list->PageObjName . "_row_" . $tbl_franchise_info_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbl_franchise_info->fld_name->Visible) { // fld_name ?>
		<td<?php echo $tbl_franchise_info->fld_name->CellAttributes() ?>>
<span<?php echo $tbl_franchise_info->fld_name->ViewAttributes() ?>>
<?php echo $tbl_franchise_info->fld_name->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_franchise_info->fld_location->Visible) { // fld_location ?>
		<td<?php echo $tbl_franchise_info->fld_location->CellAttributes() ?>>
<span<?php echo $tbl_franchise_info->fld_location->ViewAttributes() ?>>
<?php echo $tbl_franchise_info->fld_location->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_franchise_info->fld_rating->Visible) { // fld_rating ?>
		<td<?php echo $tbl_franchise_info->fld_rating->CellAttributes() ?>>
<span<?php echo $tbl_franchise_info->fld_rating->ViewAttributes() ?>>
<?php echo $tbl_franchise_info->fld_rating->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_franchise_info->fld_is_active->Visible) { // fld_is_active ?>
		<td<?php echo $tbl_franchise_info->fld_is_active->CellAttributes() ?>>
<span<?php echo $tbl_franchise_info->fld_is_active->ViewAttributes() ?>>
<?php echo $tbl_franchise_info->fld_is_active->ListViewValue() ?></span>
</td>
	<?php } ?>
	<?php if ($tbl_franchise_info->fld_created_on->Visible) { // fld_created_on ?>
		<td<?php echo $tbl_franchise_info->fld_created_on->CellAttributes() ?>>
<span<?php echo $tbl_franchise_info->fld_created_on->ViewAttributes() ?>>
<?php echo $tbl_franchise_info->fld_created_on->ListViewValue() ?></span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tbl_franchise_info_list->ListOptions->Render("body", "right", $tbl_franchise_info_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($tbl_franchise_info->CurrentAction <> "gridadd")
		$tbl_franchise_info_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($tbl_franchise_info->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($tbl_franchise_info_list->Recordset)
	$tbl_franchise_info_list->Recordset->Close();
?>
<div class="ewGridLowerPanel">
<?php if ($tbl_franchise_info->CurrentAction <> "gridadd" && $tbl_franchise_info->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>">
<table class="ewPager">
<tr><td>
<?php if (!isset($tbl_franchise_info_list->Pager)) $tbl_franchise_info_list->Pager = new cPrevNextPager($tbl_franchise_info_list->StartRec, $tbl_franchise_info_list->DisplayRecs, $tbl_franchise_info_list->TotalRecs) ?>
<?php if ($tbl_franchise_info_list->Pager->RecordCount > 0) { ?>
<table class="ewStdTable"><tbody><tr><td>
	<?php echo $Language->Phrase("Page") ?>&nbsp;
<div class="input-prepend input-append">
<!--first page button-->
	<?php if ($tbl_franchise_info_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $tbl_franchise_info_list->PageUrl() ?>start=<?php echo $tbl_franchise_info_list->Pager->FirstButton->Start ?>"><i class="icon-step-backward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-step-backward"></i></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($tbl_franchise_info_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $tbl_franchise_info_list->PageUrl() ?>start=<?php echo $tbl_franchise_info_list->Pager->PrevButton->Start ?>"><i class="icon-prev"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-prev"></i></a>
	<?php } ?>
<!--current page number-->
	<input class="input-mini" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tbl_franchise_info_list->Pager->CurrentPage ?>">
<!--next page button-->
	<?php if ($tbl_franchise_info_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $tbl_franchise_info_list->PageUrl() ?>start=<?php echo $tbl_franchise_info_list->Pager->NextButton->Start ?>"><i class="icon-play"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-play"></i></a>
	<?php } ?>
<!--last page button-->
	<?php if ($tbl_franchise_info_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-small" href="<?php echo $tbl_franchise_info_list->PageUrl() ?>start=<?php echo $tbl_franchise_info_list->Pager->LastButton->Start ?>"><i class="icon-step-forward"></i></a>
	<?php } else { ?>
	<a class="btn btn-small disabled"><i class="icon-step-forward"></i></a>
	<?php } ?>
</div>
	&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tbl_franchise_info_list->Pager->PageCount ?>
</td>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tbl_franchise_info_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tbl_franchise_info_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tbl_franchise_info_list->Pager->RecordCount ?>
</td>
</tr></tbody></table>
<?php } else { ?>
	<?php if ($Security->CanList()) { ?>
	<?php if ($tbl_franchise_info_list->SearchWhere == "0=101") { ?>
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
	foreach ($tbl_franchise_info_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
</div>
</td></tr></table>
<script type="text/javascript">
ftbl_franchise_infolistsrch.Init();
ftbl_franchise_infolist.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$tbl_franchise_info_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbl_franchise_info_list->Page_Terminate();
?>
