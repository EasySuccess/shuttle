$(document).ready(function(){
	AV.initialize(APP_ID, APP_KEY);
	bootbox.setLocale("zh_TW");
	storeValue("url", window.location.href);
	
	if(detectIE() > 0){	
		window.location.href="checkbrowser.html";
		// alert("IE is not support!");
	}
		
	checkLogin().then(function(user) {
		
		switch(user.get("type")){
			case "admin":
				window.location.href = "admin/index.html";
				break;
			case "agent":
				window.location.href = "admin/index.html";
				break;
			default:
				$("#actionBarSignUpBtn").hide();
				$("#actionBarLogInBtn").hide();
				$("#actionBarLogOutBtn").show();
				
				$("#userAvatar").show(); 
				$("#userAvatar >span:eq(1)").html(user.get("username"));
				user.get("wallet").fetch().then(function(wallet){
					$("#userAvatar >span:eq(3)").html("   $" + wallet.get("balance"));
				});
				
				break;
		}
		
	}, function(errorCode) {
	
		switch (errorCode) {
			default:
				$("#actionBarSignUpBtn").show();
				$("#actionBarLogInBtn").show();
				$("#actionBarLogOutBtn").hide();
				
				$("#userAvatar").hide(); 
				$(".user-backend-link").hide(); 
				
				//User must logon to access user backend pages;
				var backendPath = ["user-profile.html", "user-change-password.html", "user-asset.html", "user-queue.html", "user-transaction.html"];
				
				var path = window.location.pathname;
				var shortPath = path.substring(path.lastIndexOf("/") + 1);
				
				if(backendPath.indexOf(shortPath) !== -1){
					window.location.href = "index.html";
				}
				
				break;
		}
		
	});
						
	$("#registerForm").validator().submit(function(e){		
		
		if (!e.isDefaultPrevented()) {
			disableUI();
		
			var newUser = new AV.User();
			var newWallet;
			
			newUser.set("username", $("#registerForm #username").val());
			newUser.set("name", $("#registerForm #name").val());
			newUser.set("password", $("#registerForm #password").val());
			newUser.set("email", $("#registerForm #email").val());
			newUser.set("type", $("#registerForm #type").val());
			
			var query = new AV.Query(AV.User);
			query.equalTo("type", "admin");
			
			query.first().then(function(admin){
				
				newUser.set("owner", admin);
				
				var clsWallet = AV.Object.extend(tblWallet);
				var wallet = new clsWallet();
				
				wallet.set("balance", 0);
				return wallet.save();
				
			}).then(function(wallet){
			
				newWallet = wallet;
			
				newUser.set("wallet", newWallet);
				return newUser.signUp();
				
			}).then(function(newUser){
			
				bootbox.alert("註冊成功", function(){
					if(getStoredValue("url") != null){
						window.location.href = getStoredValue("url");
					}else{
						window.location.href = "index.html";
					};
				});
				
			}, function(err){
			
				delobject(newWallet).then(function(){
					
					console.log(err);
					switch(err.code){
						case 202:
							//"Username has already been taken"
							bootbox.alert("此帳號已註冊");
							break;
						case 203:
							//"此电子邮箱已经被占用"
							bootbox.alert("此電子郵箱已被註冊");
							break;
						default:
							bootbox.alert("註冊失敗");
							break;
					}
					
				}, function(err){
					bootbox.alert("註冊失敗");
				});
				
			});
				
			e.preventDefault();
		}
	});
		
	$("#loginForm").validator().submit(function(e) {
	
		if (!e.isDefaultPrevented()) {
			
			disableUI();
			
			var username = $("#loginForm #username").val();
			var password = $("#loginForm #password").val();
			
			AV.User.logIn(username, password, {
				success: function(user) {
					bootbox.alert("登入成功", function(){
						if(getStoredValue("url") != null){
							window.location.href = getStoredValue("url");
						}else{
							window.location.href = "index.html";
						};
					});
				},
				error: function(object, error) {
					console.log(error);
					switch(error.code){
						case 210:
							//"The username and password mismatch."
							bootbox.alert("使用者名稱或密碼錯誤");
							break;
						case 211:
							//"Could not find user"
							bootbox.alert("使用者名稱或密碼錯誤");
							break;
						default:
							bootbox.alert("登入失敗");
							break;
					}
					
					enableUI();
				}
			});
			
			e.preventDefault();
		}
	});
});