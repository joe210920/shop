/**
 * 身分字號驗證
 */


function check_user_id(user_id) {
		
		user_id = user_id.toUpperCase();
		
		var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		var num = new Array(10, 11, 12, 13, 14, 15, 16, 17, 34, 18, 19, 20, 21, 22, 35, 23, 24, 25, 26, 27, 28, 29, 32, 30, 31, 33);
		if(user_id.length == 0) {
			alert("請填寫身份字號");
			return 0;
		}
		if(user_id.length > 10 && user_id.length <10) {
			alert("身份字號只有10碼");
			return 0;
		}
		var firstWordIndex = tab.indexOf(user_id.charAt(0));
		if(firstWordIndex == -1) {
			alert("身份字號第一碼為大寫英文字母");
			return 0;
		}
		var strWord = "" + num[firstWordIndex];
		
		for(var i = 1; i < user_id.length; i++) {
			strWord += user_id.charAt(i);
		}
		var sum = 0;
		for(var i = 0; i < strWord.length - 1; i++) {
			if(i == 0) {
				sum += parseInt(strWord.charAt(i)) * 1;
				continue;
			}
			sum += parseInt(strWord.charAt(i)) * (10 - i);
		}
		var checkNum = 10 - (sum % 10);
		
		if(checkNum == parseInt(strWord.charAt(10))) {
			alert("身份字號驗證正確");
			return 1;
		} else if(checkNum == 10) { 
			alert("身分字號驗證正確");
			return 1;
		} else {
			alert("身份字號驗證錯誤");
			return 0;
		} 
		
	}