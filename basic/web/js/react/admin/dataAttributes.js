class Add extends React.Component{
  JQueryCall(){
	  	$('#add-attribute > button').click(addAttribute);
		$('#add-attribute > div input').on('input', formRealTime);
  }
  componentDidMount(){ this.JQueryCall(); }
  render(){
    return (
      <React.Fragment>
        <div id="add-attribute">
		  <input type="hidden" id="queryParameters" value="" />
          <div>
            <h2>Please, input attribute name(only English)</h2>
            <input type="text" id="theme" />
          </div>
          <button>Insert attribute</button>
        </div>
      </React.Fragment>
    );
  }
}
class List extends React.Component{
  constructor(props){
	  super(props);
	  this.state = {
		  listSheet: []
	  };
  }
  redirectToAttribute(pm,state){ 
	let ds;
	
	if(state === 0){ ds = '/admin?svc=dataManagment&subSVC=filters&attr=' + pm + '#edit'; } 
	else{ ds = '/admin?svc=dataManagment&subSVC=filters&attr=' + pm + '#add'; }
	
	return ds;
  }
  
  fetchData(svc,rq){
	  fetch(svc, rq)
        .then(response => response.json())
		.then(data => this.setState({ listSheet: data }))
		.catch(error => {
			alert('Response error!');
			console.log(error);
		});
  }
  componentDidMount(){
	  
	  const requestOptions = {
        method: 'GET'
	  };
	  
	  this.fetchData('/admin/api/dataServices/filters/Attributes/show', requestOptions);
  }
  render(){
	const myStates = this.state.listSheet.map((myState) =>
		<a href={this.redirectToAttribute(myState.name, parseInt(myState.status))} className="list-cont">{ myState.name }</a>
	);
	
    return (
      <React.Fragment>
        <section id="attributes-list">{myStates}</section>
      </React.Fragment>
    );
  }
}


const HeaderRender = (hash) => {
  let render = "";
  switch(hash){
    case "#add": render = '<a href="#list">Back to list</a>'; break;
    default: render = '<a href="#add">New attribute</a>'; break;
  }
  
  $('.data-page > header nav').html(render);
}
document.title = "Data Attributes";
const UIRender = (hash) => {
  switch(hash){
    case "#add": document.title = "Add new Attribute"; break;
    default: document.title = "Data Attributes"; break;
  }
}
const UXRender = (hash) => {
  switch(hash){
    case "#add": ReactDOM.render(<Add />, document.querySelector('.data-page > main')); break;
    default: ReactDOM.render(<List />, document.querySelector('.data-page > main')); break;
  }
}


$('.data-page > header h2').html(document.title);

const jsonQueryConstructor = (query,pm) => {
	$(query).val(pm);
}

const addAttribute = (e,t) => {
	let jsonQuery = $('#add-attribute > #queryParameters').val();
	
	var fd = new FormData();
	fd.append('svcQuery', jsonQuery);
	
	let validEmpty = JSON.parse(jsonQuery);
	
	if($('#add-attribute > div input#theme').val() !== ''){
		fetch('/admin/api/dataServices/filters/Attribute/send', {
			method: 'POST',
			body: fd
		}).then(response => {
			if(response.status !== 503 && response.status !== 404){ 
				alert('The current attribute has been added successfully!');
				window.location.assign('/admin?svc=dataManagment&subSVC=attributes#list'); 
			}
			else{ alert('Send error!'); }
		}).catch(error => {
			alert('Response error!');
		});
	}
	else{ alert('You didn\'t enter the attribute name!'); }
}

const formRealTime = (e,t) => {
	
	let q = {},
		r = "";
		
	var currentValue = $('#add-attribute > div input#theme').val();
	
	q = {
		parameters: {
			attribute: currentValue,
			group: 'meta'
		}
	};
	
	r = JSON.stringify(q);
		
	
	
	jsonQueryConstructor('#add-attribute > #queryParameters', r);
}

$(document).ready(function(){
	$(window).on('hashchange',function(){
		let s = window.location.hash;
		
		HeaderRender(s);
		UIRender(s);
		UXRender(s);
	}).trigger('hashchange');
});
