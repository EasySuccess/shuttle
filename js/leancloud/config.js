var APP_ID = "PgtVwjyTv9QJCtBSxb19WhAn";
var APP_KEY = "skOfznQ2ebewMyb7r9H4gWze";

var tblArtwork = "Dev_Artwork";
var tblArtworkPhoto = "Dev_Artwork_Photo";
var tblBuyQueue = "Dev_Buy_Queue";
var tblPreorderQueue = "Dev_Preorder_Queue";
var tblSellQueue = "Dev_Sell_Queue";
var tblTransaction = "Dev_Transaction";
var tblWallet = "Dev_Wallet";
var tblAccountBook = "Dev_Account_Book";
var tblVirtualAccount = "Dev_Virtual_Account";

var CONSOLE_LOGGING = true;
var NO_PER_PAGE = 10;
var CURRENT_HTML_COOKIE = "currentHTMLCookie";

var BOOTBOX_LOCALE = "zh_TW";

var LOCK_KEY_INITIAL = 1;
var LOCK_KEY_MAX = 2;

var PRE_ORDER_FEE = 100;
var ORDER_FEE = 100;

var DATE_FORMAT = "YYYY-MM-DD";
var DATE_FORMAT_DATEPICKER =  "yyyy-mm-dd";
var DATETIME_FORMAT = "YYYY-MM-DD HH:mm:ss";

var BONUS_PARTITION = 0.6;
var BONUS_LEVEL = 6;

/*
Error Code Definitions:
*/
var errMessage = {};
errMessage.e1000 = "Buyer cannot buy its own artwork.";
errMessage.e1001 = "Buyer cannot order the same artwork twice.";
errMessage.e1002 = "Seller cannot sell artwork when nobody is in queue.";
errMessage.e1003 = "Artwork is not in 'hold' state when selling.";
errMessage.e1004 = "Balance is not enough to pay.";
errMessage.e1005 = "The type was not defined. It should be either 'buy' or 'sell'.";
errMessage.e1006 = "The selected queue locked failed, No Position assigned. Queue Id: ";
errMessage.e1007 = "User cancelled the action.";
errMessage.e1008 = "Nobody in queue";
errMessage.e1009 = "The queue has been done lucky draw already";
errMessage.e1010 = "File not found.";
errMessage.e1011 = "Admin account not found.";
