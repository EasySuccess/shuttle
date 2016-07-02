/*
General Function
*/

function closeFancyBox(){
	parent.window.location.reload(true);
	parent.$.fancybox.close(); //Doesn't work in location domain. Tested in Github domain
}

function disableUI(){
	$(".blackout").show();
	$(".btn").prop('disabled', true);
}

function enableUI(){
	$(".blackout").hide();
	$(".btn").prop('disabled', false);
}

function emptyUndefined(arg){
	if(arg === "undefined"){
		return "";
	}else if(arg === undefined){
		return ""
	}else{
		return arg;
	}
}

function formatFloat(num, pos){
  var size = Math.pow(10, pos);
  return Math.round(num * size) / size;
}

//Cookie Function
function storeValue(key, value) {
	if (localStorage) {
		localStorage.setItem(key, value);
	} else {
		$.cookies.set(key, value);
	}
}

function getStoredValue(key) {
	if (localStorage) {
		return localStorage.getItem(key);
	} else {
		return $.cookies.get(key);
	}
}

function removeAllStoredValue(){
	if(localStorage){
		localStorage.clear();
	} else {
		_.each($.cookie(), function(cookie){
			$.removeCookie(cookie);
		});
	}
}

function removeStoredValue(key){
	if(localStorage){
		localStorage.removeItem(key);
	} else {
		$.removeCookie(key);
	}
}

function replaceUrlParam(url, paramName, paramValue){

    var pattern = new RegExp('('+paramName+'=).*?(&|$)')
    var newUrl=url;
	
    if(url.search(pattern)>=0){
        newUrl = url.replace(pattern,'$1' + paramValue + '$2');
    }
    else{
        newUrl = newUrl + (newUrl.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue 
    }
    return newUrl;
}

/*
WebPage Specific Function
*/
function checkLogin(){

	return new Promise(function(resolve, reject){
	
		var currentUser = AV.User.current();
		
		if (currentUser) {
			resolve(currentUser);
		} else {
			reject(1);//"尚未登入"
		}
		
	});
	
}

function logOut(){
	AV.User.logOut();
	location.href = "index.html";
}

function buildPager(argHtml, argCurrentPage, argTotalPage){
				
	var html = argHtml;
	var currentPage = parseInt(argCurrentPage);
	var totalPages = parseInt(argTotalPage);
	var SKIP_PAGES = 3;

	$(".pagination").empty();
	
	if(totalPages > 1){
	
		for(var i = 1; i <= totalPages; i++){
			
			if( (i == 1) && ( currentPage != 1)){
				$(".pagination").append("<li class='next'><a href='" + replaceUrlParam(html, "page", 1) + "'>首頁</a></li>");
			}
			
			if(i == (currentPage + SKIP_PAGES)){
				$(".pagination").append("<li class='dots'>...</li>");
			}else if(i == (currentPage - SKIP_PAGES)){
				$(".pagination").append("<li class='dots'>...</li>");
			}else if(i == currentPage){
				$(".pagination").append("<li class='active'><a href='" + replaceUrlParam(html, "page", i) + "'>" + i + "</a></li>");
			}else if( (i < (currentPage + SKIP_PAGES )) && ( i > (currentPage - SKIP_PAGES )) ){
				$(".pagination").append("<li><a href='" + replaceUrlParam(html, "page", i) + "'>" + i + "</a></li>");
			}
					
			if( (currentPage != totalPages) && (i == totalPages) ){
				$(".pagination").append("<li class='next'><a href='" + replaceUrlParam(html, "page", totalPages) + "'>尾頁</a></li>");
			}
			
		}
	}
}

function getInstantRate(rateStart, rateTarget, startDate, endDate){
	
	/*
		Applied formula
		an = a1 + nd
		d = (an - a1)/n
	*/
	
	// if(CONSOLE_LOGGING){console.log("InstantRate")};
	
	var instantRate = rateStart;
	var today = new Date();
	var todayMN = convertToDateMN(today);
	
	if(todayMN >= startDate && todayMN <= endDate){		
			
		var bidDuration = moment(endDate).diff(startDate, "day");
		var bidDayGone = moment(today).diff(startDate, "day");
		var rateDiff = (rateTarget - rateStart)/bidDuration;
		
		var todayRateStart = formatFloat(rateStart +  bidDayGone * rateDiff, 2);
		
		if(bidDayGone == bidDuration){
			instantRate = todayRateStart;
		}else {
			var todayRateEnd = formatFloat(rateStart +  (bidDayGone + 1) * rateDiff, 2);
			var percent = (today - todayMN)/(60*60*24*1000);
			
			instantRate = todayRateStart +  (todayRateEnd - todayRateStart) * percent;
		}
		
	}else if(todayMN > endDate){
		instantRate = rateTarget;
	}

	return formatFloat(instantRate, 0);
}

function getDateRate(rateStart, rateTarget, startDate, endDate, date){
	
	/*
		Applied formula
		an = a1 + nd
		d = (an - a1)/n
	*/
	
	// if(CONSOLE_LOGGING){console.log("getDateRate")};
	
	var instantRate = rateStart;
	
	if(date >= startDate && date <= endDate){		
			
		var bidDuration = moment(endDate).diff(startDate, "day");
		var bidDayGone = moment(date).diff(startDate, "day");
		var rateDiff = (rateTarget - rateStart)/bidDuration;
		
		instantRate = formatFloat(rateStart +  bidDayGone * rateDiff, 2);
		
	}else if(date > endDate){
		instantRate = rateTarget;
	}

	return formatFloat(instantRate, 0);
}

function shuffle(array) {
	var currentIndex = array.length, temporaryValue, randomIndex ;

	// While there remain elements to shuffle...
	while (0 !== currentIndex) {

		// Pick a remaining element...
		randomIndex = Math.floor(Math.random() * currentIndex);
		currentIndex -= 1;

		// And swap it with the current element.
		temporaryValue = array[currentIndex];
		array[currentIndex] = array[randomIndex];
		array[randomIndex] = temporaryValue;
	}

	return array;
}

function convertToDateMN(date){
	return new Date(new Date(date).setHours(0,0,0,0));
}
	
function updateWallet(user, change, type){

	if(CONSOLE_LOGGING){console.log("updateWallet");}
		
	return new Promise(function(resolve ,reject){
		
		var err = {};		
		
		user.get("wallet").fetch().then(function(wallet){
			
			var balance = wallet.get("balance");
			var newBalance = parseFloat(balance) + parseFloat(change);
			
			if (newBalance >= 0){
				
				writeAccountBook(user, type, balance, newBalance, change).then(function(){
					wallet.set("balance", newBalance);
					return wallet.save();
				}).then(function(){
					resolve();
				}, function(err){
					reject(err);
				});
				
			}else{
				err.code = 1004;
				err.message = errMessage.e1004;
				reject(err);
			}
			
		}, function(err){
			reject(err);
		});
		
	});
}

function writeAccountBook(user, type, balance, newBalance, change){
	
	if(CONSOLE_LOGGING){console.log("writeAccountBook");}
	
	return new Promise(function(resolve, reject){
		
		var clsAccountBook = AV.Object.extend(tblAccountBook);
		var newRecord = new clsAccountBook();
		
		newRecord.set("user",user);
		newRecord.set("type", type);
		newRecord.set("oldBalance", balance);
		newRecord.set("newBalance", newBalance);
		newRecord.set("change", change);
				
		newRecord.save().then(function(newRecord){
			resolve(newRecord);
		}, function(err){
			reject(err);
		});
	})
}

function delobject(object){
	
	/*
		Tested by Ben @ 2015/09/15
	*/
	
	if(CONSOLE_LOGGING){console.log("delobject");}
	
	return new Promise(function(resolve, reject){
		object.destroy().then(function(object){
			resolve();
		}, function(err){
			reject(err);
		});
	});
}

/**
 * detect IE
 * returns version of IE or false, if browser is not Internet Explorer
 */
function detectIE() {

	if(CONSOLE_LOGGING){console.log("detectIE");}
	
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
       // IE 12 => return version number
       return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    // other browser
    return false;
}