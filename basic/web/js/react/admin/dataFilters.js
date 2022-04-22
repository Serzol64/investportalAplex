var params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            var a = e.split('=');
            p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
            return p;
        },
        {}
    );

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

class Add extends React.Component{
  JQueryCall(){
		let elService = $('.add-fields > footer button:nth-child(1)'),
			eventService = openProccess;
			
		let eleService = $('.add-fields > footer button:nth-child(2)'),
			eventService2 = saveFilters;

	    elService.click(eventService);
	    eleService.click(eventService2);
	    
	    
		$('.add-fields > main #fieldType').on('input change', selectFilterType);

		
		sessionStorage.setItem('currentAttr', capitalizeFirstLetter(params['attr']));
  }
  componentDidMount(){ this.JQueryCall(); }
  render(){
    return (
      <React.Fragment>
        <div className="add-fields">
		  <input type="hidden" id="queryParameters" value="" />
          <header><h2>Add current attribute filters group</h2></header>
          <main>
            <div>
              <input type="text" name="field" id="field" placeholder="Enter the field name" />
              <select name="fieldType" id="fieldType">
                <option>Select form field type</option>
                <option value="default">Data field</option>
                <option value="country">Country field</option>
                <option value="region">Region field</option>
                <option value="int">Integer field</option>
                <option value="precentable">Precentable field</option>
                <option value="cost">Cost field</option>
                <option value="selecting">Selecting field</option>
                <option value="photogallery">Photogallery</option>
              </select>
            </div>
          </main>
          <footer><button>Add field</button><button>Save fields</button></footer></div>
      </React.Fragment>
    );
  }
}
class Edit extends React.Component{
  constructor(props){
	 super(props); 
	 this.state = {
		  currentAttributeSheet: []
	 };
  }
  JQueryCall(){
	  let mainButs = [$('.edit-fields > footer button:nth-child(1)'), $('.edit-fields > footer button:nth-last-child(1)')];
	  let events = [updateFiltersData, deleteFilters];
	  
	  for(let i = 0; i < events.length; i++){ mainButs[i].click(events[i]); }
	  
	  $('.edit-fields > main #fieldType').on('input change', selectFilterType);
	  $('.edit-fields > header input').on('change', updateAttribute);
	 
	  
	  sessionStorage.setItem('currentAttr', capitalizeFirstLetter(params['attr']));
  }
  componentDidMount(){
	  let qpm = {
		  parameters: {
			attribute: params['attr']
		  }
	  };
	  
	  var fd = new FormData();
	  fd.append('svcQuery', JSON.stringify(qpm));
	  
	  const requestOptions = {
		method: 'POST',
        body: fd
	  };
	  
	  fetch('/admin/api/dataServices/filters/Filters/show', requestOptions)
        .then(response => response.json())
        .then(data => this.setState({ currentAttributeSheet: data }));
        
     this.JQueryCall();
  }
  render(){
	let responseList = this.state.currentAttributeSheet,
		inputedQueres = [];
		
	responseList.map((myState) => {
		inputedQueres.push({
			f: myState.name,
			t: myState.type
		});
	});
	
	sessionStorage.setItem('cae', JSON.stringify(inputedQueres));
	const parametersRender = responseList.map((myState) =>
			<div>
				<input type="text" name="field" id="field" defaultValue={ myState.name } />
				<select name="fieldType" id="fieldType">
					<option>Select form field type</option>
					<option value="default" selected={ myState.type === "text" ? true : false }>Data field</option>
					<option value="country" selected={ myState.type === "country" ? true : false }>Country field</option>
					<option value="region" selected={ myState.type === "region" ? true : false }>Region field</option>
					<option value="int" selected={ myState.type === "int" ? true : false }>Integer field</option>
					<option value="precentable" selected={ myState.type === "precentable" ? true : false }>Precentable field</option>
					<option value="cost" selected={ myState.type === "cost" ? true : false }>Cost field</option>
					<option value="selecting" selected={ myState.type === "selecting" ? true : false }>Selecting field</option>
					<option value="photogallery" selected={ myState.type === "photogallery" ? true : false }>Photogallery</option>
				</select>
			</div>
	);
	
    return (
      <React.Fragment>
        <div className="edit-fields">
          <header>
			<h2>Edit current filters group for attribute</h2>
			<input type="text" id="theme" defaultValue={ params['attr'] }/>
		  </header>
          <main>{parametersRender}</main>
          <footer><button>Update fields</button><button>Delete all filters and current attribute</button></footer></div>
      </React.Fragment>
    );
  }
}

const HeaderRender = (hash) => {
  let render = '';
  switch(hash){
    case "#add": render = '<a href="/admin?svc=dataManagment&subSVC=attributes#list">Back to list</a>'; break;
	case "#edit": render = '<a href="/admin?svc=dataManagment&subSVC=attributes#list">Back to list</a>'; break;
  }
  
   $('.data-page > header nav').html(render);
}
document.title = "Data Filters";
const UIRender = (hash) => {
  switch(hash){
    case "#add": document.title = "Add new Filter"; break;
    case "#edit": document.title = "Edit current Filter"; break;
  }
}
const UXRender = (hash) => {
  switch(hash){
    case "#add": ReactDOM.render(<Add />, document.querySelector('.data-page > main')); break;
    case "#edit": ReactDOM.render(<Edit />, document.querySelector('.data-page > main')); break;
  }
}


$('.data-page > header h2').html(document.title);


const openProccess = (e, t) => { 
		
	let result, endpoint;
	
	let up;
		
	result = {
		parameters: {
			attribute: sessionStorage.getItem('currentAttr'),
			field: sessionStorage.getItem('currentField'),
			type: sessionStorage.getItem('currentType')
		}
	};
			
	up = '/admin/api/dataServices/filters/Filters/send';
		
	endpoint = up;
	
	var fds = new FormData();
	fds.append('svcQuery', JSON.stringify(result));
	
	
	const sendRequest = { method: 'POST', body: fds };
		
	fetch(endpoint, sendRequest)
		.then(response => {
			if(response.ok){ 
				alert('The current attribute filter has been added successfully!');
				sessionStorage.removeItem('currentField');
				sessionStorage.removeItem('currentType');
				resetForm('#add-fields');
		    }
			else{ alert('Connection to the service failed to perform this operation! Try again;-)'); }
		}).catch(error => {
			alert('Response error!');
		});
}

const resetForm = (el) => {
	
	$(el + '> main #field').val('');
	$(el + '> main #fieldType option:selected').remove();
}


const saveFilters = (e,t) => {
	let q = {
		 parameters: { 
			attribute: sessionStorage.getItem('currentAttr'), 
			group: 'data' 
		 }
	};
			 
	var qa = new FormData();
	qa.append('svcQuery', JSON.stringify(q));
			 
	fetch('/admin/api/dataServices/filters/Attribute/send', {
		method: 'POST',
		body: qa
	}).then(response => {
		if(response.ok){ window.location.assign('/admin?svc=dataManagment&subSVC=attributes#list'); }
		else{ alert('Generate error'); }
	}).catch(error => {
		alert('Generate response error!');
	});
}


const updateAttribute = (e) => {
	let old = sessionStorage.getItem('currentAttr'),
		newA = $('.edit-fields > header input').val();
		
	let qpm = {
		parameters: {
			attribute: old,
			newAttribute: newA
		}
	};
	
	var fd = new FormData();
	fd.append('svcQuery', JSON.stringify(qpm));
	
	fetch('admin/api/dataServices/filters/Attribute/update', { method: 'POST', body: fd })
		.then((response) => { if(response.ok){ updateURLAttr(newA); } })
		.catch(error => alert('Update Service Error!'));
	
	
}

const updateURLAttr = (attribute) => {
	if (history.pushState) {
		sessionStorage.removeItem('currentAttr');
		
        var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
        var newUrl = baseUrl + '?svc=dataManagment&subSVC=filters&attr=' + attribute + '#edit';
        history.pushState(null, null, newUrl);
        
        sessionStorage.setItem('currentAttr', attribute);
    }
    else { alert('Client Service Error'); }
}
const updateFiltersData = (e,t) => {
	let savings = JSON.parse(sessionStorage.getItem('cae')),
		updateItem = $('.edit-fields > main div input'),
		updateType = $('.edit-fields > main div select');
		
	savings.forEach((item,index) => {
		
		var fdq = [new FormData(), new FormData()];
			
		let sd = [item.f, item.t],
			uid = updateItem.eq(index).val(),
			utd = updateType.eq(index).val();
			
		if(sd[1] !== utd){
			let qpmT = {
				parameters: {
					attribute: sessionStorage.getItem('currentAttr'),
					field: sd[0],
					type: utd || sd[1]
				}
			};
			
			fdq[0].append('svcQuery', JSON.stringify(qpmT));
			
			fetch('admin/api/dataServices/filters/Filters/update', { method: 'POST', body: fdq[0] })
				.then((response) => {
					if(response.ok){
						console.log('Send success!');
						validManySend = true;
					}
				})
				.catch(error => console.log('Send error!'));
		}
		if(sd[0] !== uid){
			let qpmF = {
				parameters: {
					attribute: sessionStorage.getItem('currentAttr'),
					field: sd[0],
					newField: uid,
					type: utd || sd[1]
				}
			};
			
			fdq[1].append('svcQuery', JSON.stringify(qpmF));
			
			fetch('admin/api/dataServices/filters/Filters/update', { method: 'POST', body: fdq[1] })
				.then((response) => {
					if(response.ok){
						console.log('Update success!');
					}
				})
				.catch(error => console.log('Update error!'));
		}
		
	});
	
	window.location.assign('http://investportal.aplex/admin?svc=dataManagment&subSVC=attributes#list');
	
	
}
const deleteFilters = (e,t) => {
	let jsonQuery = {
		parameters: {
			attribute: sessionStorage.getItem('currentAttr')
		}
	};
	
	var fdDA = new FormData();
	fdDA.append('svcQuery', JSON.stringify(jsonQuery));
	
	fetch('/admin/api/dataServices/filters/Attribute/delete', {
		method: 'POST',
		body: fdDA
	}).then(response => console.log('Delete proccess...'));
	
	window.location.assign('admin?svc=dataManagment&subSVC=attributes#list');
	
}

const redirectToDataForm = (e,t) => {
	let currentLink = $(this).text(),
					  redirect;
					  
					  
	switch(currentLink){
		case 'Add': redirect = '/admin?svc=dataManagment&subSVC=filters&attr='+ $(this).prev().prev().prev().prev().prev().prev().text() +'#add'; break;
		case 'Edit': redirect = '/admin?svc=dataManagment&subSVC=filters&attr='+ $(this).prev().prev().prev().text() +'#edit'; break;
	}
					  
					  
	window.location.assign(redirect);
}

const selectFilterType = () => {
    var optionSelected = $('.add-fields > main #fieldType, .edit-fields > main #fieldType');
    var valueSelected  = optionSelected.val();
    
	var field = $('.add-fields > main #field, .edit-fields > main #field').val();
			
	sessionStorage.setItem('currentField', field);
	sessionStorage.setItem('currentType', valueSelected);
}

$(document).ready(function(){
  $(window).on('hashchange',function(){
		let s = window.location.hash;
		
		UIRender(s);
		UXRender(s);
		HeaderRender(s);
  }).trigger('hashchange');
  
});
