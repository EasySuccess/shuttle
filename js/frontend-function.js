function getUserTransaction(user){
	
	var clsTransaction = AV.Object.extend(tblTransaction);
	var buyQuery = new AV.Query(clsTransaction);
	
	buyQuery.equalTo("buyer", user);
	buyQuery.limit(1000);
	buyQuery.descending("createdAt");
	
	buyQuery.find().then(function(transactions){
		
		var template = $("#buy-record >tr:eq(0)")[0].outerHTML;
		$("#buy-record").empty();
		
		var promise = new AV.Promise.as();
		$.each(transactions, function(i, transaction){
			$("#buy-record").append(template);
			
			promise = promise.then(function(){
				return transaction.get("artwork").fetch();
			}).then(function(artwork){
			
				var state = "";
				switch(transaction.get("state")){
					case "fail":
						state = "失敗";
						break;
					case "successful":
						state = "成功";
						break;
					default:
						break;
				}
				var purchasePrice = transaction.get("purchasePrice");
				var serviceCharge = transaction.get("serviceCharge");
				var createdAt = moment(transaction.createdAt).format(DATETIME_FORMAT);
				
				$("#buy-record >tr:eq(" + i + ") >td:eq(0)").html(artwork.get("name"));
				$("#buy-record >tr:eq(" + i + ") >td:eq(1)").html(state);
				$("#buy-record >tr:eq(" + i + ") >td:eq(2)").html(purchasePrice);
				$("#buy-record >tr:eq(" + i + ") >td:eq(3)").html(serviceCharge);
				$("#buy-record >tr:eq(" + i + ") >td:eq(4)").html(purchasePrice + serviceCharge);
				$("#buy-record >tr:eq(" + i + ") >td:eq(5)").html(createdAt);
				
			})
			
			return promise;
			
		});
		
	}, function(err){
		console.log(err);
	});
	
	var sellQuery = new AV.Query(clsTransaction);
	
	sellQuery.equalTo("seller", user);
	sellQuery.limit(1000);
	sellQuery.descending("createdAt");
	
	sellQuery.find().then(function(transactions){
		
		var template = $("#sell-record >tr:eq(0)")[0].outerHTML;
		$("#sell-record").empty();
		
		var promise = new AV.Promise.as();
		$.each(transactions, function(i, transaction){
			$("#sell-record").append(template);
			
			promise = promise.then(function(){
				return transaction.get("artwork").fetch();
			}).then(function(artwork){
			
				var state = "";
				switch(transaction.get("state")){
					case "fail":
						state = "失敗";
						break;
					case "successful":
						state = "成功";
						break;
					default:
						break;
				}
				var purchasePrice = transaction.get("purchasePrice");
				var serviceCharge = transaction.get("serviceCharge");
				var createdAt = moment(transaction.createdAt).format(DATETIME_FORMAT);
				
				$("#sell-record >tr:eq(" + i + ") >td:eq(0)").html(artwork.get("name"));
				$("#sell-record >tr:eq(" + i + ") >td:eq(1)").html(state);
				$("#sell-record >tr:eq(" + i + ") >td:eq(2)").html(purchasePrice);
				$("#sell-record >tr:eq(" + i + ") >td:eq(3)").html(serviceCharge);
				$("#sell-record >tr:eq(" + i + ") >td:eq(4)").html(purchasePrice - serviceCharge);
				$("#sell-record >tr:eq(" + i + ") >td:eq(5)").html(createdAt);
				
			})
			
			return promise;
			
		});
		
	}, function(err){
		console.log(err);
	});
	
	var clsAccountBook = AV.Object.extend(tblAccountBook);
	var accountQuery =  new AV.Query(clsAccountBook);
	
	accountQuery.equalTo("user", user);
	accountQuery.limit(1000);
	accountQuery.descending("createdAt");
	
	accountQuery.find().then(function(records){
		
		var template = $("#account-record >tr:eq(0)")[0].outerHTML;
		$("#account-record").empty();
		
	
		$.each(records, function(i, record){
			$("#account-record").append(template);
		
			var type = "";
			switch(record.get("type")){
				case "recharge":
					type = " 充值";
					break;
				case "trade":
					type = "交易";
					break;
				case "fee":
					type = "手續費";
					break;
				case "bonus":
					type = "獎金";
					break;
				case "withdraw":
					type = "提現";
					break;
				default:
					type = record.get("type");
					break;
			}
			var oldBalance = record.get("oldBalance");
			var newBalance = record.get("newBalance");
			var change = record.get("change");
			var createdAt = moment(record.createdAt).format(DATETIME_FORMAT);
			
			$("#account-record >tr:eq(" + i + ") >td:eq(0)").html(type);
			$("#account-record >tr:eq(" + i + ") >td:eq(1)").html(oldBalance);
			$("#account-record >tr:eq(" + i + ") >td:eq(2)").html(newBalance);
			$("#account-record >tr:eq(" + i + ") >td:eq(3)").html(change);
			$("#account-record >tr:eq(" + i + ") >td:eq(4)").html(createdAt);
			
		});
		
	}, function(err){
		console.log(err);
	});
}

function getArtworkListFE(){
	
	return new Promise(function(resolve, reject){
		// var template = $("#owl-card-paly .owl-item:eq(0)")[0].outerHTML;
		var template = $("#owl-card-paly .item:eq(0)")[0].outerHTML;
		$("#owl-card-paly").empty();

		var clsArtwork = AV.Object.extend(tblArtwork);
		var qryArtwork = new AV.Query(clsArtwork);
		
		qryArtwork.equalTo("state", "available");
		qryArtwork.find().then(function(artworks) {

			$.each(artworks, function(i, artwork){
				$("#owl-card-paly").append(template);			

				var object_id = artwork.id;
				var startPrice = artwork.get("startPrice");
				var targetPrice = artwork.get("targetPrice");
				var startPreDate = artwork.get("startPreDate");
				var endPreDate = artwork.get("endPreDate");
				var startBidDate = artwork.get("startBidDate");
				var endBidDate = artwork.get("endBidDate");
				var updatedAt = moment(artwork.updatedAt).format(DATETIME_FORMAT);
				var instantPrice = getInstantRate(startPrice, targetPrice, startBidDate, endBidDate);
								
				$("#owl-card-paly .item:eq(" + i + ") .course-thumbnail >a").attr("href", "item.html?artwork_id=" + object_id);
				$("#owl-card-paly .item:eq(" + i + ") .register-btn").attr("href", "item.html?artwork_id=" + object_id);
				$("#owl-card-paly .item:eq(" + i + ") .cover-info h4").html(artwork.get("name"));
				$("#owl-card-paly .item:eq(" + i + ") .title >a").html(artwork.get("desc"));
				$("#owl-card-paly .item:eq(" + i + ") .course-meta li:eq(0) >span:eq(1)").html(artwork.get("name"));
				$("#owl-card-paly .item:eq(" + i + ") .course-meta li:eq(1) >span:eq(1)").html(artwork.get("type"));
				$("#owl-card-paly .item:eq(" + i + ") .course-meta li:eq(2) >span:eq(1)").html(moment(startPreDate).format(DATE_FORMAT) + "至" + moment(endPreDate).format(DATE_FORMAT));
				$("#owl-card-paly .item:eq(" + i + ") .course-meta li:eq(3) >span:eq(1)").html(moment(startBidDate).format(DATE_FORMAT) + "至" + moment(endBidDate).format(DATE_FORMAT) );
				$("#owl-card-paly .item:eq(" + i + ") .course-meta li:eq(4) >span:eq(1)").html(targetPrice);
				$("#owl-card-paly .item:eq(" + i + ") .course-meta li:eq(5) >span:eq(1)").html(startPrice);
				$("#owl-card-paly .item:eq(" + i + ") .course-action  .price").html("$" + instantPrice);
				
				var relation = artwork.relation("photo");
				var query = relation.query();
				
				query.equalTo("type", "main").first().then(function(photo){
					if(photo != null){
						$("#owl-card-paly .item:eq(" + i + ") .course-thumbnail img").attr("src", photo.get("photo").url());
					}
				});
			});
		}).then(function(){
			resolve();
		}, function(error) {
			console.log("Error: " + error.code + " " + error.message);
			reject(error);
		});
	});
}

function getArtworkFE(artworkId){	
	
	return new Promise(function(resolve, reject){
		
		var clsArtwork = AV.Object.extend(tblArtwork);
		var qryArtwork = new AV.Query(clsArtwork);

		qryArtwork.get(artworkId, {
			success: function(artwork){
			
				var object_id = artwork.id;
				var startPrice = artwork.get("startPrice");
				var targetPrice = artwork.get("targetPrice");
				var startPreDate = artwork.get("startPreDate");
				var endPreDate = artwork.get("endPreDate");
				var startBidDate = artwork.get("startBidDate");
				var endBidDate = artwork.get("endBidDate");
				var updatedAt = moment(artwork.updatedAt).format(DATE_FORMAT + ' HH:MM:SS');
				var instantPrice = getInstantRate(startPrice, targetPrice, startBidDate, endBidDate);
				
				var today = new Date();
				var todayMN = convertToDateMN(today);
				
				if( todayMN >= startPreDate && todayMN <= endPreDate){
					$("#pre-order-btn").show();
					
					$("#buy-btn").hide();
					
					$("#queue-modal-btn").show();
					
				}else if( todayMN >= startBidDate && todayMN <= endBidDate){
					$("#pre-order-btn").hide();
					$("#pre-order-period").wrapInner("<s>")
					
					$("#buy-btn").show();
					
					$("#queue-modal-btn").show();
				}else{
					$("#pre-order-period").show();
					$("#order-period").show();
					$("#pre-order-btn").hide();
					$("#buy-btn").hide();
					$("#queue-modal-btn").hide();
				}
				
				$("#course-body #name").html(artwork.get("name"));
				$("#cart-products-name").html(artwork.get("name"));
				$("#course-body >h2").html(artwork.get("type"));
				$("#heading-type").html(artwork.get("type"));
				$("#course-body >p").html(artwork.get("desc"));
				$("#course-body #start-price").html("$" + startPrice);
				$("#course-body #target-price").html("$" + targetPrice);
				
				$("#sidebar-description #pre-start-date").html(moment(startPreDate).format(DATE_FORMAT));
				$("#sidebar-description #pre-end-date").html(moment(endPreDate).format(DATE_FORMAT));
				$("#sidebar-description #bid-start-date").html(moment(startBidDate).format(DATE_FORMAT));
				$("#sidebar-description #bid-end-date").html(moment(endBidDate).format(DATE_FORMAT));
				$(".price").html("$" + instantPrice);
				
				var clsBuyQueue = AV.Object.extend(tblBuyQueue);
				var qryBuyQueue = new AV.Query(clsBuyQueue);
				qryBuyQueue.equalTo("artwork", artwork);
				qryBuyQueue.count().then(function(count){
					$("#sidebar-description #queue").html(count);
					
					var relation = artwork.relation("photo");
					var query = relation.query();
					
					return query.find();
					
				}).then(function(photos){
				
					var template = $("#owl-item-image .item:eq(0)")[0].outerHTML;
					$("#owl-item-image").empty();
				
					if(photos.length > 0){
						$.each(photos, function(index, photo){
							if(photo.get("type") === "main"){
									$("#cart-image").attr("src", photo.get("photo").url());
							}
						
							$("#owl-item-image").append(template);
							$("#owl-item-image .item:eq(" + index + ") >img").attr("src", photo.get("photo").url());
						});
					}
					
				}).then(function(){
					resolve();
				}, function(err){
					reject(err);
				});
			},
			error: function(object, err){
				reject(err);
			}
		});
	});
}

function getArtworkQueueByUser(user){

	var template = $("#product-list .single-course:eq(0)")[0].outerHTML;
	$("#product-list").empty();
	
	return new Promise(function(resolve,reject){
		
		var clsBuyQueue = AV.Object.extend(tblBuyQueue);
		var qryBuyQueue = new AV.Query(clsBuyQueue);
		
		qryBuyQueue.equalTo("user", user);
		
		qryBuyQueue.find().then(function(queues){
		
			if(queues.length === 0){
				$("#product-list").append("<div>暫時沒有排隊中的商品</div>");
			}
		
			$.each(queues, function(i, queue){
				
				$("#product-list").append(template);			
				
				var artwork = queue.get("artwork");
				var position = queue.get("position");
				
				artwork.fetch().then(function(artwork){
					
					var object_id = artwork.id;
					var startPrice = artwork.get("startPrice");
					var targetPrice = artwork.get("targetPrice");
					var startPreDate = artwork.get("startPreDate");
					var endPreDate = artwork.get("endPreDate");
					var startBidDate = artwork.get("startBidDate");
					var endBidDate = artwork.get("endBidDate");
				
					$("#product-list .single-course:eq(" + i + ") .cover >a").attr("href", "item.html?artwork_id=" + object_id);
					$("#product-list .single-course:eq(" + i + ") .title-queue >a").html(artwork.get("name"));
					$("#product-list .single-course:eq(" + i + ") .title-queue >a").attr("href", "item.html?artwork_id=" + object_id);
					$("#product-list .single-course:eq(" + i + ") .course-meta li:eq(0) >span:eq(1)").html(artwork.get("type"));
					$("#product-list .single-course:eq(" + i + ") .course-meta li:eq(2) >span:eq(1)").html(moment(startPreDate).format(DATE_FORMAT) + " 至 "+moment(startBidDate).format(DATE_FORMAT));
					$("#product-list .single-course:eq(" + i + ") .course-meta li:eq(3) >span:eq(1)").html(moment(startBidDate).format(DATE_FORMAT) + " 至 "+moment(endBidDate).format(DATE_FORMAT));
					$("#product-list .single-course:eq(" + i + ") .queuebtn").attr("id", object_id);
					
					if(position != null){
						$("#product-list .single-course:eq(" + i + ") .course-meta li:eq(1) >span:eq(1)").html(position);
					}else{
						$("#product-list .single-course:eq(" + i + ") .course-meta li:eq(1) >span:eq(1)").html("未有排序");
					}
					
					var relation = artwork.relation("photo");
					var query = relation.query();
					
					query.equalTo("type", "main").first().then(function(photo){
						if(photo != null){
							$("#product-list .single-course:eq(" + i + ") .cover img").attr("src", photo.get("photo").url());
						}
					});
				});
			});
			
			$(".queuebtn").click(function(e){
			
				disableUI();
			
				var artworkId = $(this).attr("id");
				var user = AV.User.current();
				
				bootbox.confirm("確定放棄排隊?", function(answer){
					if(answer){				
					
						var clsArtwork = AV.Object.extend(tblArtwork);
						var qryArtwork = new AV.Query(clsArtwork);
						
						qryArtwork.get(artworkId, {
							success: function(artwork){
								leaveQueue(artwork, user, "buy").then(function(){
									bootbox.alert("操作成功", function(){
										window.location.reload(true);
									});
								}, function(err){
									bootbox.alert("錯誤: " + err);
									enableUI();
								});
							}, 
							error: function(object, err){
								bootbox.alert("錯誤: " + err);
								enableUI();
							}
						});		
					}else{
						enableUI();
					}
				});
			});
			
			resolve();
		}, function(err){
			reject(err);
		});
	});
}

function getArtworkAssetByUser(user){

	var template = $("#product-list .single-course:eq(0)")[0].outerHTML;
	$("#product-list").empty();
	
	return new Promise(function(resolve,reject){
		
		var clsArtwork = AV.Object.extend(tblArtwork);
		var qryArtwork = new AV.Query(clsArtwork);
		
		qryArtwork.equalTo("owner", user);
		
		qryArtwork.find().then(function(artworks){
		
			if(artworks.length === 0){
				$("#product-list").append("<div>沒有找到拍賣品</div>");
			}
		
			$.each(artworks, function(i, artwork){
				
				$("#product-list").append(template);			
								
				var clsBuyQueue = AV.Object.extend(tblBuyQueue);
				var qryBuyQueue = new AV.Query(clsBuyQueue);
				qryBuyQueue.equalTo("artwork", artwork);
				
				qryBuyQueue.count().then(function(count){
					
					if(count === 0){
						$("#product-list .single-course:eq(" + i + ") .queuebtn").prop("disabled", true);
					}
					
					var object_id = artwork.id;
					var name = artwork.get("name");
					var type = artwork.get("type");
					var startPrice = artwork.get("startPrice");
					var targetPrice = artwork.get("targetPrice");
					var startPreDate = artwork.get("startPreDate");
					var endPreDate = artwork.get("endPreDate");
					var startBidDate = artwork.get("startBidDate");
					var endBidDate = artwork.get("endBidDate");
				
					$("#product-list .single-course:eq(" + i + ") .cover >a").attr("href", "item.html?artwork_id=" + object_id);
					$("#product-list .single-course:eq(" + i + ") .title-queue >a").html(name);
					$("#product-list .single-course:eq(" + i + ") .title-queue >a").attr("href", "item.html?artwork_id=" + object_id);
					$("#product-list .single-course:eq(" + i + ") .course-meta li:eq(0) >span:eq(1)").html(type);
					$("#product-list .single-course:eq(" + i + ") .course-meta li:eq(1) >span:eq(1)").html(count);
					$("#product-list .single-course:eq(" + i + ") .course-meta li:eq(2) >span:eq(1)").html(moment(startPreDate).format(DATE_FORMAT) + " 至 "+moment(startBidDate).format(DATE_FORMAT));
					$("#product-list .single-course:eq(" + i + ") .course-meta li:eq(3) >span:eq(1)").html(moment(startBidDate).format(DATE_FORMAT) + " 至 "+moment(endBidDate).format(DATE_FORMAT));
					$("#product-list .single-course:eq(" + i + ") .queuebtn").attr("id", object_id);
					
					var relation = artwork.relation("photo");
					var query = relation.query();
					
					query.equalTo("type", "main").first().then(function(photo){
						if(photo != null){
							$("#product-list .single-course:eq(" + i + ") .cover img").attr("src", photo.get("photo").url());
						}
					});
				});
			});
			
			$(".queuebtn").click(function(e){
			
				disableUI();
			
				var artworkId = $(this).attr("id");
				var user = AV.User.current();
								
				bootbox.confirm("確定放售?", function(answer){
					if(answer){						
						sell(artworkId).then(function(){
							bootbox.alert("操作成功", function(){
								window.location.reload(true);
							});
						}, function(err){
								bootbox.alert("錯誤: " + err.message);	
								enableUI();
						});
					}else{
						enableUI();
					}
				});
			});
			
			resolve();
		}, function(err){
			reject(err);
		});
	});
}

function bounceRate() {
	var collection = $(".course-details");
	
	var Interval = setInterval(function() {
		collection.each(function() {	
			var startBidDate, endBidDate;
			var startPrice = 1, targetPrice = 1;
			
			$.each($(this).find("li"), function(index, element){
				switch(index){
					case 3:
						var period = $(element).children("span").last().html();
						startBidDate = convertToDateMN(period.substring(0, 10));
						endBidDate = convertToDateMN(period.substring(11));
						break;
					case 4:
						targetPrice = parseInt($(element).children("span").last().html());
						break;
					case 5:
						startPrice = parseInt($(element).children("span").last().html());
						break;
					default:
						break;
				}
			});
			
			var instantPrice = getInstantRate(startPrice, targetPrice, startBidDate, endBidDate);
			
			$(this).find(".price").html("$" + instantPrice);
			
		});
	}, 1000);
}

function bounceRateItem(){	
	var itemInterval = setInterval(function() {
		var startBidDate = convertToDateMN($("#bid-start-date").html());
		var endBidDate = convertToDateMN($("#bid-end-date").html());
		var startPrice = parseInt(($("#start-price").html()).substring(1));
		var targetPrice =  parseInt(($("#target-price").html()).substring(1));
		
		instantPrice = getInstantRate(startPrice, targetPrice, startBidDate, endBidDate);
		
		$(".price").html("$" + instantPrice);
	}, 1000);
}

function prepareChart(){
	/*chart.js*/
	
	var startBidDate = $("#bid-start-date").html();
	var endBidDate = $("#bid-end-date").html();
	var startDateMN = convertToDateMN(startBidDate);
	var endDateMN = convertToDateMN(endBidDate);
	var startPrice = parseInt(($("#start-price").html()).substring(1));;
	var targetPrice =  parseInt(($("#target-price").html()).substring(1));
	
	var mStartDate = moment(startBidDate);
	var mEndDate = moment(endBidDate);
	
	var duration = mEndDate.diff(mStartDate, "days");
	var sliceSize = formatFloat(duration / 10, 0);
	
	var labels = [];
	var data = [];
	
	for(var i = 0; i <= duration - 1; i = i + sliceSize){
		var temp = moment(startBidDate);
		var thatDay = temp.add(i, "day").format(DATE_FORMAT);
		var thatDayMN =  convertToDateMN(thatDay);
		
		labels.push(thatDay);
		data.push(getDateRate(startPrice, targetPrice, startDateMN, endDateMN, thatDayMN));
	}
	
	labels.push(endBidDate);
	data.push(targetPrice);
	
	var lineChartData = {
		labels: labels,
		datasets: [{
			label: "My First dataset",
			fillColor : "rgba(151,187,205,0.2)",
			strokeColor : "rgba(151,187,205,1)",
			pointColor : "rgba(151,187,205,1)",
			pointStrokeColor : "#fff",
			pointHighlightFill : "#fff",
			pointHighlightStroke : "rgba(151,187,205,1)",
			data: data
		}]
	}

	return lineChartData;
}