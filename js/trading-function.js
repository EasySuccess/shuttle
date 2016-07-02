function shareBonusAPI(user, bonus){

	return new Promise(function(resolve, reject){
		
		if(user != null){
			
			user.fetch().then(function(user){
				return shareBonus(user, bonus);
			}).then(function(){
				resolve();
			}, function(err){reject(err);});
			
		}else{
			var query = new AV.Query(AV.User);
			query.equalTo("type", "admin");
			
			query.first().then(function(admin){
				if(admin != null){
					return updateWallet(admin, bonus, "bonus");
				}else{
					err.code = 1011;
					err.message = errMessage.e1011;
					
					reject(err);
				}
			}).then(function(){
				resolve();
			}, function(err){reject(err);});
			
		}
	});
}

function shareBonus(user, bonus, level){

	if(CONSOLE_LOGGING){console.log("shareBonus");}

	return new Promise(function(resolve, reject){
	
		var myBonus = formatFloat(bonus * BONUS_PARTITION, 0);
		var toSuperBonus = bonus - myBonus;
		var currentlevel = (level == null) ? 1 : level;
	
		console.log("Bonus Level: " + currentlevel);

		if(myBonus > 0){
			
			if( (currentlevel === BONUS_LEVEL) || (user.get("type") === "admin") ){
				updateWallet(user, bonus, "bonus").then(function(){
					resolve();
				}, function(err){reject(err);})
			}else{
				updateWallet(user, myBonus, "bonus").then(function(){
					return user.get("owner").fetch();
				}).then(function(userSuper){
					return shareBonus(userSuper, toSuperBonus, currentlevel + 1);
				}).then(function(){
					resolve();
				}, function(err){reject(err);})
			}
			
		}else{
			resolve();
		}		
	});	
	
}

function closeBid(artwork){

	if(CONSOLE_LOGGING){console.log("closeBid");}
	
	var clsBuyQueue = AV.Object.extend(tblSellQueue);
	var qryBuyQueue= new AV.Query(clsBuyQueue);
	var price = artwork.get("target") * 0.1;
	qryBuyQueue.equalTo("artwork",artwork);
	
	qryBuyQueue.find().then(function(qryBuyQueue){
		var i = 0;
		while(qryBuyQueue.length > i){
			var buyList = qryBuyQueue[i];
			var user = buyList.get("user")
			user.fetch().then(function(user){
				refund(user,price);
			});
			i++;
		}	
	},function(err){
		reject(err);
	});
}

function trade(artwork,buyer){

/*
	
*/
	if(CONSOLE_LOGGING){console.log("trade");}
	
	return new Promise(function(resolve, reject){
		
		var err = {};
		var seller = artwork.get("owner");
		var instantRate = formatFloat(getInstantRate(artwork.get("startPrice"), artwork.get("targetPrice"), artwork.get("startBidDate"), artwork.get("endBidDate")), 0);		
		var serviceChargeAbs = formatFloat(instantRate * 0.01, 0);
		var serviceCharge = -1 * formatFloat(instantRate * 0.01, 0);
		
		var buyerBalanceChange = -1 * (instantRate);
		var sellerBalanceChange = instantRate;
	
		updateWallet(buyer, buyerBalanceChange, "trade").then(function(){
		
			return updateWallet(buyer, serviceCharge, "fee");
		}).then(function(){
			return seller.fetch();
		}).then(function(seller){
			return updateWallet(seller, sellerBalanceChange, "trade");
		}).then(function(){
			return updateWallet(seller, serviceCharge, "fee");
		}).then(function(){
			var clsTransaction = AV.Object.extend(tblTransaction);
			var newTransaction = new clsTransaction();
			
			newTransaction.set("purchasePrice", instantRate);
			newTransaction.set("serviceCharge", serviceChargeAbs);
			newTransaction.set("artwork", artwork);
			newTransaction.set("buyer", buyer);
			newTransaction.set("seller", seller);
			newTransaction.set("state", "successful");
			
			return newTransaction.save();
		}).then(function(){
			
			artwork.set("owner", buyer);
			return artwork.save();
		}).then(function(){
		
			var sellerSuper = seller.get("owner");			
			return shareBonusAPI(sellerSuper, serviceChargeAbs);
			
		}).then(function(){
		
			var buyerSuper = buyer.get("owner");
			return shareBonusAPI(buyerSuper, serviceChargeAbs);
			
		}).then(function(){
			
			resolve();
		}, function(err){reject(err);});
	});
}

function buy(artworkId,buyer){

/*
	This function is not in user because the sell queue is disable.
*/

	if(CONSOLE_LOGGING){console.log("buy");}
	
	return new Promise(function(resolve, reject){
	
		var artwork = AV.Object.createWithoutData(tblArtwork, artworkId);
		var clsSellQueue = AV.Object.extend(tblSellQueue);
		var qrySellQueue= new AV.Query(clsSellQueue);
		qrySellQueue.equalTo("artwork",artwork);
		qrySellQueue.ascending("position");
		
		qrySellQueue.first().then(function(queue){
			
			if(queue !== undefined){
				
				var seller = queue.get("user");
				
				var clsBuyQueue = AV.Object.extend(tblBuyQueue);
				var qryBuyQueue = new AV.Query(clsBuyQueue);
				qryBuyQueue.equalTo("artwork",artwork);
				
				qryBuyQueue.count().then(function(count){
					if(count > 0){
						reject("buy(): Buy & Sell conflict!");
					}else{
						return artwork.fetch();
					}
				}).then(function(artwork){
					return trade(artwork, buyer);
				}).then(function(){
					return seller.fetch();
				}).then(function(seller){
					return leaveQueue(artwork, seller, "sell");
				}, function(err){reject(err);});
				
			}else{
				return enterBuyQueueAndPosition(artworkId, buyer);
			}
		}).then(function(){
			resolve(true);
		}, function(err){reject(err);});
	});			
}

function sell(artworkId){

	if(CONSOLE_LOGGING){console.log("sell");}
		
	return new Promise(function(resolve, reject){
		
		var err = {};
		var artwork = AV.Object.createWithoutData(tblArtwork, artworkId);
		
		artwork.fetch().then(function(artwork){
		
			var clsBuyQueue = AV.Object.extend(tblBuyQueue);
			var qryBuyQueue = new AV.Query(clsBuyQueue);

			qryBuyQueue.equalTo("artwork",artwork);
			qryBuyQueue.ascending("position");
			
			qryBuyQueue.first().then(function(queue){
			
				if( queue !== undefined ){
					var buyer = queue.get("user");
					
					return buyer.fetch().then(function(buyer){
						return trade(artwork, buyer);
					}).then(function(){
						return leaveQueue(artwork, buyer, "buy");
					}).then(function(){
						resolve(true);
					}, function(err){
						switch(err.code){
							case 1004:
								//ToDo: Add fail transaction log to the buyer
								leaveQueue(artwork, buyer, "buy").then(function(){
									return sell(artworkId);
								}).then(function(){
									resolve();
								}, function(err){
									reject(err);
								});
								break;
							default:
								reject(err);
								break;
						}
					});
					
				}else{
					// var clsSellQueue = AV.Object.extend(tblSellQueue);
					// var newQueue = new clsSellQueue();
					// var owner = artwork.get("user");
					
					// newQueue.set("artwork", artwork);
					// newQueue.set("user", artwork.get("user"));
					
					// return newQueue.save().then(function(newQueue){
						// return assignPosition(artwork,owner,newQueue,"sell");
					// }).then(function(newQueue){
						// return toggleArtworkState(artwork, "available");
					// }).then(function(){
						// resolve(newQueue);
					// }, function(err){reject(err);});
					
					err.code = 1002;
					err.message = errMessage.e1002;
					reject(err);
				}
			});
		});
	});
}

function toggleArtworkState(artwork, state){

	if(CONSOLE_LOGGING){console.log("toggleArtworkState");}
	
	return new Promise(function(resolve, reject){
		
		switch(state){
			case "hold":
				artwork.set("state", "hold");
				break;
			case "available":
				artwork.set("state", "available");
				break;
			default:
				break;
		}
		return artwork.save();
	}).then(function(updateArtwork){
		resolve(updateArtwork);
	}, function(err){reject(err);});
	
}

function enterBuyQueue(artworkId, user){
/*

	The deposit is $100 in every pre-order product.
	User cannot pre-order the same product twice.
	User cannot pre-order their own product.
	
*/
	if(CONSOLE_LOGGING){console.log("enterBuyQueue");}
	
	var err = {};
	
	return new Promise(function(resolve, reject){
	
		var artwork = AV.Object.createWithoutData(tblArtwork, artworkId);
		
		artwork.fetch().then(function(artwork){
			
			if(artwork.get("owner").id ===  user.id){
				err.code = 1000;
				err.message = errMessage.e1000;
				reject(err);
			}else{
				var clsBuyQueue = AV.Object.extend(tblBuyQueue);
				var qryBuyQueue = new AV.Query(clsBuyQueue);
							
				qryBuyQueue.equalTo("artwork",artwork);
				qryBuyQueue.equalTo("user",user);

				qryBuyQueue.count().then(function (count){
					if (count === 0){
						var change = -1 * PRE_ORDER_FEE;
						updateWallet(user, change, "fee").then(function(){
																							
							var newQueue = new clsBuyQueue();
							newQueue.set("artwork",artwork);
							newQueue.set("user",user);
							
							return newQueue.save();
							
						}).then(function(newQueue){
						
							console.log("enterBuyQueue(): New Queue added");
							resolve(newQueue);
							
						}, function(err){
							reject(err);
						});
					}else{
						err.code = 1001;
						err.message = errMessage.e1001;
						reject(err);
					}
				}, function(err){
					reject(err);
				});
			}
		});	
	});			
}

function enterBuyQueueAndPosition(artworkId, user){
	
	if(CONSOLE_LOGGING){console.log("enterBuyQueueAndPosition");}
	
	return new Promise(function(resolve, reject){
		
		enterBuyQueue(artworkId,user).then(function(newQueue){
		
			var artwork = AV.Object.createWithoutData(tblArtwork, artworkId);
			
			return assignPosition(artwork, user, newQueue, "buy");
		}).then(function(newQueue){
			resolve(newQueue);
		}, function(err){reject(err);});
	});
}

function assignPosition(artwork,user,newQueue,type){

/*
	Add user to the last seat of queue,
	If lock conflict found, Position will remain undefined
	
	Type: "sell" , "buy"
	
	Tested by Ben @ 2015/09/14
*/

	if(CONSOLE_LOGGING){console.log("assignPosition");}
	var err = {};
	
	return new Promise(function(resolve, reject){
			
		var clsQueue;
		
		if(type === "buy"){
			clsQueue = AV.Object.extend(tblBuyQueue);
		}else if (type === "sell"){
			clsQueue = AV.Object.extend(tblSellQueue);
		}else{
			err.code = 1005;
			err.message = errMessage.e1005;
			reject(err);
		}
		
		var qryQueue = new AV.Query(clsQueue);
		
		qryQueue.equalTo("artwork",artwork);
		qryQueue.notEqualTo("user", user);
		qryQueue.select("position", "lockKey");
		qryQueue.descending("position");
		
		qryQueue.first().then(function(queue){
			if( queue !== undefined ){
			
				queue.increment("lockKey");
				queue.save().then(function(updateQueue){
					
					console.log("assignPosition(): Incremented lock, queue data is now: " + JSON.stringify(updateQueue));
					
					if(updateQueue.get("lockKey") <= LOCK_KEY_MAX){
						
						console.log("assignPosition(): Queue lock successful, adding queue.");
						
						newQueue.set("position", queue.get("position") + 1);
						
						newQueue.save().then(function(){
							
							console.log("assignPosition(): New Position added");
							updateQueue.increment("lockKey", -1);
							return updateQueue.save();
							
						}).then(function(updateQueue){
						
							console.log("assignPosition(): Incremented unlock, queue data is now: " + JSON.stringify(updateQueue));
							resolve(newQueue);
							
						}, function(err){
							reject(err);
						});
						
					}else{
						
						err.code = 1006;
						err.message = errMessage.e1006 + updateQueue.id;
						reject(err);
						
					}
				}, function(err){
						reject(err);
				});
			}else{
			
				newQueue.set("position", 1);
				
				newQueue.save().then(function(newQueue){
								
					console.log("assignPosition(): New Position added");
					resolve(newQueue);
					
				});
			}
		}, function(err){
			reject(err);
		});
	});
}

function hold(artwork){
	
	/*
		To withdraw a artwork from sell queue
		
		Tested by Ben @ 2015/09/11
	*/

	if(CONSOLE_LOGGING){console.log("hold");}
	
	return new Promise(function(resolve, reject){
		var clsSellQueue = AV.Object.extend(tblSellQueue);
		var qrySellQueue = new AV.Query(clsSellQueue);
		
		qrySellQueue.equalTo("artwork", artwork);
		
		qrySellQueue.first().then(function(queue){
			
			if(queue === undefined){
				reject("hold(): No record in Sell Queue");
			}
			
			var owner = queue.get("user");
			return leaveQueue(artwork, owner, "sell");
		}).then(function(){
			return toggleArtworkState(artwork, "hold");
		}).then(function(){
			resolve(true);
		}, function(err){reject(err);});	
	});
}

function leaveQueue(artwork,user,type){

	/*
		Any user leave their position, 
		other users will take over and advance by 1 after that user to maintain the queue sequence
		Limit by 1000 records
		
		Tested by Ben @ 2015/09/11
	*/
	
	if(CONSOLE_LOGGING){console.log("leaveQueue");}
	
	var err = {};

	return new Promise(function(resolve, reject){
	
		var clsQueue;
		if(type === "buy"){
			clsQueue = AV.Object.extend(tblBuyQueue);
		}else if (type === "sell"){
			clsQueue = AV.Object.extend(tblSellQueue);
			toggleArtworkState(artwork, "hold");
		}else{
			err.code = 1005;
			err.message = errMessage.e1005;
			reject(err);
		}
		
		var qryQueue= new AV.Query(clsQueue);
		qryQueue.limit("1000");
		var tunePosition = 0;
		
		qryQueue.equalTo("artwork",artwork);
		qryQueue.equalTo("user", user);
		qryQueue.select("position");
		
		qryQueue.first().then(function(userQueue){
			tunePosition  = userQueue.get("position");
			
			return delobject(userQueue);
		}).then(function(){
			if(tunePosition !== undefined){
				var qryQueue2 = new AV.Query(clsQueue);
				qryQueue2.limit("1000");
				
				qryQueue2.equalTo("artwork", artwork);
				qryQueue2.select("position");
				qryQueue2.ascending("position");
				qryQueue2.skip(tunePosition - 1);
		
				return qryQueue2.find().then(function(results){
									
					var promises = [];
					
					$.each(results, function(index, result){		
						result.increment("position", -1);
						promises.push(result.save());
					});
					
					return AV.Promise.when(promises);
					
				}, function(err){reject(err);});
			}
		}).then(function(){
			resolve(true);
		}, function(err){reject(err);});
	});
}
