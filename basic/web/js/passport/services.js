$(document).ready(function () {
    $('.add-but').click(function(e,t){
		var sfd = new FormData();
		let subscribeQuery = {
				login: get_cookie('portalId'),
				region: $('.passport-page > main .services-settings header select').val(),
				svc: subscribeAttrsData()
		};
		
		sfd.append('svcQuery', JSON.stringify(subscribeQuery));
		
		alertify.set('notifier','position', 'top-right');
		alertify.set('notifier','delay', 5);
		
		
		fetch('/passport/api/post?svc=services', { method: 'POST', body: sfd})
			.then((response) => {
				if(response.status === 200){ alertify.success("Subscribe data updated!"); }
				else{ alertify.error("Subscribe data update error!"); }
			});
		
		
	});
});

function subscribeAttrsData(){
	let qArray = [],
		sourceQuery = $('.passport-page > main .services-settings footer .services-selectors .selector input:checked');
		
	for(let i = 0; i < sourceQuery.length; i++){ qArray.push(sourceQuery.eq(i).val()); }

	return qArray;
}
