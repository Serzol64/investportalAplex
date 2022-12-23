
var investForm = [new FormData(), new FormData()],
	queryObject = [{}, {}];

$(document).ready(function(){
	$('.new-ad-form-modal-data > #footer button').click(function(e,t){
	   let endpointCodeSearch = '/experts/api/post';
		   contentSearch = {},
		   metaSearch = {};
		  
	   metaSearch = {
			name: get_cookie('portalId'),
			specialization: $('.new-ad-form-modal-data > #content ul li section.form div *:nth-last-child(1)#specialization').val(),
			experience: $('.new-ad-form-modal-data > #content ul li section.form div *:nth-last-child(1)#exprStart').val(),
			legalState: $('.new-ad-form-modal-data > #content ul li section.form div *:nth-last-child(1)#legalState').val()
	   };
		  
	   contentSearch = {
			i: {
				about: $('.new-ad-form-modal-data > #content ul li section.form div *:nth-last-child(1)#about').val(),
				slogan: $('.new-ad-form-modal-data > #content ul li section.form div *:nth-last-child(1)#slogan').val(),
				history: $('.new-ad-form-modal-data > #content ul li section.form div *:nth-last-child(1)#specHistory').val(),
				isFreeAppreal: Boolean($('.new-ad-form-modal-data > #content ul li section.form div *:nth-last-child(1)#isFreeAppreal').val())
			},
			m: {
				attachments: $('.new-ad-form-modal-data > #content ul li section.form div *:nth-last-child(1)#attachments').val(),
				amounts: $('.new-ad-form-modal-data > #content ul li section.form div *:nth-last-child(1)#amounts').val(),
				price: $('.new-ad-form-modal-data > #content ul li section.form div *:nth-last-child(1)#prices').val()
			},
			c: {
				region: $('.new-ad-form-modal-data > #content ul li section.form div *:nth-last-child(1)#region').val()
			}
	   };
	   
	   queryObject[1] = {
		  service: 'newExpert',
		  parameters: {
			  person: metaSearch,
			  content: contentSearch
		  }
	   };
	  
	   investForm[1].append('svcQuery', JSON.stringify(queryObject[1]));
	  
	   fetch(endpointCodeSearch, { method: 'POST', body: investForm[1] })
		.then((response) => { if(response.ok){ window.location.reload(true); } })
		.catch(() => { alert('Failed to send data! Try again later...'); });
  });
  $('#search-header > ul li *[data-formState=\'yes\'], #search-footer > ul li input').change(function(e,t){
	  findDataLoading(false);
	  $('#investors-list > .body').html('');
	  let searchQuery = {};
	  
	  if($('#search-header > ul li:nth-child(1) *[data-formState=\'yes\']').val() !== 'all'){ searchQuery.theme = $('#search-header > ul li:nth-child(1) *[data-formState=\'yes\']').val(); }
	  if($('#search-header > ul li:nth-child(2) *[data-formState=\'yes\']').val() !== 'all'){ searchQuery.cost = $('#search-header > ul li:nth-child(2) *[data-formState=\'yes\']').val(); }
	  if($('#search-header > ul li:nth-child(3) *[data-formState=\'yes\']').val() !== 'all'){ searchQuery.region = $('#search-header > ul li:nth-child(3) *[data-formState=\'yes\']').val(); }
	  if($('#search-header > ul li:nth-child(4) *[data-formState=\'yes\']').val() !== 'all'){ searchQuery.type = $('#search-header > ul li:nth-child(4) *[data-formState=\'yes\']').val(); }
	  
	  if($('#search-footer > ul li input:checked').val() === 'true'){ searchQuery.isFreeAppreal = true; }
	  
	  queryObject[0] = searchQuery;
	  
	  investForm[0].append('svcQuery', JSON.stringify(queryObject[0]));
	  
	  fetch('/experts/api/get?service=find', { method: 'POST', body: investForm[0] })
		.then((response) => {
			if(response.status === 200){
				return response.json();
			}
			else{ alert('Results not found!'); }
		})
		.then((data) => {
			let resultAppend = '';
			
			data.map((result) => {
				let titleImage = '',
					expertParam = ['', '', '', ''];
				
				if(result.titleImage){ titleImage = '<img src="' + result.titleImage + '" data-block="header" />'; }
				else{ titleImage = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAACuElEQVRYhe2WPWgTcRjGf8/1I7XYuom4ODSJFcHBpNkUHcVWLYrOipp2qFr8/lgVQ4eKgrmCOkuL4tckLs5NcHIwORU3QSsoGGySu9eh52RjrjXi0mf6czzv8/7+793972BFK/rP0lILtuS9tTExZtggkAgvl2R6Vo/ZrVdHEp/+GUDaLR8A7gE9DSzfhB2eHUk+jJrpLLH5dNj8kRx2VLsrq6vdldUYO4HHQK+hmUzeG46aG2kCW/Le2k6ZB/QgO1fIJicW86Xc8nnBdeCrKYgXsxs/N8uONIGYGCPceaPmAMWRRA54CqzBnLEo2ZEAAmwIQA43mnlNmgQQDLUMQNAHUKlVi828Xe31QriMtwwAqEf0Uf/eJgBFrIkK8A5gldOZbmasdSgNYPC2dQCmhfdanGpmlWx8wUqksyASQFu7cwf4AuxNueXzjXwDbvmiYBCYmzfdjZId+STM5L3hQDYDtAFPTZr8UZ+fBYg5sYxk42Fz36QDxWz8UUsBANL50n6kaRpPLsDsYGE0+SBqZvSj+HZ5D1KuSY2DlNuaLw22DsBMKbc0gcNjwvMA8YHA7++odHV3VLq6TcEmxIewos+RnqSnvBxmTSfcFGDA9SaEzgB1xGXgC8YGc9pHg55ab9BT63WCtlGMDcAcpiuAj9m59NTb3F8BpKa8fSZOAzU5tquQTVwTdgyoCjvp+/5H3/c/muwEUDXpaGE0ftXEbqAGdjbtlvcuCyB+sxwTdgPA4MLs8eQLgNmR5EOTbWfhozMHzCGeYMG2X09+MZt4LnQpjJrcPP26s1GfhvdowPUOGXYfKBWy8X4k+9NOfpOZUlPeG0HCxMFiNjGzmK3hBAwbDhHzS24OhDUugEwNf1D+9AxkAAh4ueTmoSxQWGuZ5QCsA6h3tb9fLkCNjnfhcv1yM1a0on+un9mq9YJO1RZHAAAAAElFTkSuQmCC" alt="" data-block="header" />'; }
				
				if(result.regulator){ expertParam[1] = '<li>Is a member of the SRO: <strong>' + result.regulator + '</strong></li>'; }
				if(result[2].isFreeAppreal){ expertParam[0] = '<li>The introductory appeal is free!</li>'; }
				if(result[0].attachments){ expertParam[2] = '<li>Works with attachments: <strong>' + result[0].attachments + '</strong></li>'; }
				if(result.raiting === 5){ expertParam[3] = '<li>High raiting</li>'; }
				
				
				const paramShow = () => {
					let paramData = '';
					
					for(let i = 0; i < expertParam.length; i++){ 
						if(expertParam[i] !== ''){ paramData += expertParam[i]; } 
					}
					
					return paramData;
				};
				
				resultAppend += '<li>' + titleImage + '<div data-block="content"><h3><a href="/experts/' + result.id + '">' + result.name + '</a></h3><span>' + result.specialization + '</span><h4>' + result.slogan + '</h4></div><ul data-block="footer"><li data-field="0">Work experience: <strong>' + result.workExperience + '</strong></li>' + paramShow() + '</ul></li>';
			});
			
			$('#investors-list > .body').html(resultAppend);
			findDataLoading(true);
		});
  });
});

function findDataLoading(state){
	var loadingUI = new Loading({
		loadingBgColor: '#ffffff',
		loadingAnimation: 'image',
		animationSrc: '/images/icons/loading.gif',
		defaultApply: true
	});
	
	if(state){ loadingUI.out(); }
}
