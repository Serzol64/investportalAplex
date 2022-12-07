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
    
class RegionList extends React.Component{
	constructor(props){
		super(props);
		this.state = {
		  region: []
	    };
	}
	componentDidMount(){
		fetch('/services/0/get', { method: 'GET' })
        .then(response => response.json())
		.then(data => this.setState({ region: data }))
		.catch(error => {
			alert('Response error!');
			console.log(error);
		});
	}
	render(){
		const myStates = this.state.region.map((myState) =>
			<option value={myState.code}>{ myState.title }</option>
		);
		return (
			<React.Fragment>
			  {myStates}
			</React.Fragment>
		);
	}
}

class RegionListEditor extends React.Component{
	constructor(props){
		super(props);
		this.state = {
		  region: []
	    };
	}
	componentDidMount(){
		fetch('/services/0/get', { method: 'GET' })
        .then(response => response.json())
		.then(data => this.setState({ region: data }))
		.catch(error => {
			alert('Response error!');
			console.log(error);
		});
	}
	render(){
		const myStates = this.state.region.map((myState) =>
			<option value={myState.code} selected={this.props.current === myState.code ? true : false}>{ myState.title }</option>
		);
		return (
			<React.Fragment>
			  {myStates}
			</React.Fragment>
		);
	}
}

class Add extends React.Component{
	constructor(props){
		super(props);
		
		this.inputQuery = this.inputQuery.bind(this);
	}
	inputQuery(event){ 
		sessionStorage.setItem('queryPublic-' + event.target.name, event.target.value); 
	}
	componentDidMount(){
		$('button[type=submit].add-but').click(function(e,t){
			$('.add-portal-user').submit();
		});
		
		sessionStorage.setItem('queryPublic-role', 'admin');
		$('.add-portal-user').submit(AddEvent);
	}
	render(){
		return (
			<React.Fragment>
				<form className="add-portal-user" action="">
					<div data-cont="header">
					  <h3>Input user firstname and surname:</h3>
					  <ul>
						<li htmlFor="firstname">
						  <input type="text" onInput={this.inputQuery} onChange={this.inputQuery} name="firstname" id="firstname" placeholder="Jonh"/>
						</li>
						<li htmlFor="surname">
						  <input type="text" onInput={this.inputQuery} onChange={this.inputQuery} name="surname" id="surname" placeholder="Jonhson"/>
						</li>
					  </ul>
					</div>
					<div data-cont="content">
					  <h3>Input account data:</h3>
					  <ul>
						<li htmlFor="login">
						  <input type="text" onInput={this.inputQuery} onChange={this.inputQuery} name="login" id="login" placeholder="Login"/>
						</li>
						<li htmlFor="password">
						  <input type="password" onInput={this.inputQuery} onChange={this.inputQuery} name="password" id="password" placeholder="Password"/>
						</li>
						<li htmlFor="phone">
						  <input type="tel" onInput={this.inputQuery} onChange={this.inputQuery} name="phone" id="phone" placeholder="Phone(Enter the phone number in this format: 79012345678)" style={{ marginTop: '10%' }}/>
						</li>
						<li id="son">
						  <h4>Input contact data:</h4>
						  <ul>
							<li htmlFor="email"><input type="email" onInput={this.inputQuery} onChange={this.inputQuery} name="email" id="email" placeholder="EMail" /></li>
							<li htmlFor="country">
							  <select onChange={this.inputQuery} name="country" id="country">
								<option>Select user country</option>
								<RegionList />
							  </select>
							</li>
						  </ul>
						</li>
					  </ul>
					</div>
					<div data-cont="footer">
					  <button type="submit" className="add-but">Add admin portal user</button>
					</div>
			  </form>
			</React.Fragment>
		);
	}
}
class Edit extends React.Component{
	constructor(props){
	  super(props);
	  this.state = {
		  fda: new FormData(),
		  personalInfo: []
	  };
	  
	  this.inputQuery = this.inputQuery.bind(this);
    }
    inputQuery(event){ sessionStorage.setItem('queryPublic-' + event.target.name, event.target.value); }
    callUserData(login){
	  let dq = this.state.fda,
		  q = {
				login: params['login']
			  };
			  
	  dq.append('svcQuery', JSON.stringify(q));
	  
	  let query = { method: 'POST', body: dq };
	  
	  fetch('/admin/api/dataServices/filters/servicesPortalUsers/show', query)
        .then(response => response.json())
		.then(data => this.setState({ personalInfo: data }))
		.catch(error => {
			alert('Response error!');
			console.log(error);
		});
	  
	  
	}
	componentDidMount(){
		this.callUserData(params['login']);
		
		
		$('button[type=submit].add-but').click(function(e,t){
			$('.add-portal-user').submit();
		});
		$('.add-portal-user').submit(EditEvent);
		$('button[type=button].add-but').click(DeleteEvent);
	}
	render(){
		const pi = this.state.personalInfo;
		sessionStorage.setItem('queryPublic-firstname', pi.fn);
		sessionStorage.setItem('queryPublic-surname', pi.sn);
		sessionStorage.setItem('queryPublic-login', pi.login);
		sessionStorage.setItem('queryPublic-email', pi.mail);
		sessionStorage.setItem('queryPublic-country', pi.region);
		sessionStorage.setItem('queryPublic-phone', pi.phone);
		
		return (
			<React.Fragment>
				<form className="add-portal-user" action="">
				<div data-cont="header">
				  <h3>Update current user firstname and surname:</h3>
				  <ul>
					<li htmlFor="firstname">
					  <input type="text" onInput={this.inputQuery} onChange={this.inputQuery} name="firstname" value={ pi.fn } id="firstname" placeholder="Jonh"/>
					</li>
					<li htmlFor="surname">
					  <input type="text" onInput={this.inputQuery} onChange={this.inputQuery} name="surname" value={ pi.sn } id="surname" placeholder="Jonhson"/>
					</li>
				  </ul>
				</div>
				<div data-cont="content">
				  <h3>Update account data:</h3>
				  <ul>
					<li htmlFor="login">
					  <input type="text" onInput={this.inputQuery} onChange={this.inputQuery} name="login" id="login" value={ pi.login } placeholder="Login"/>
					</li>
					<li htmlFor="password">
					  <input type="password" onInput={this.inputQuery} onChange={this.inputQuery} name="password" id="password" placeholder="New user password"/>
					</li>
					<li id="son">
					  <h4>Update contact data:</h4>
					  <ul>
						<li htmlFor="email"><input type="email" onInput={this.inputQuery} onChange={this.inputQuery} name="email" id="email" value={ pi.mail } placeholder="EMail" /></li>
						<li htmlFor="phone">
						  <input type="tel" onInput={this.inputQuery} onChange={this.inputQuery} name="phone" id="phone" value={ pi.phone } placeholder="Phone(Enter the phone number in this format: 79012345678)" style={{ marginTop: '10%' }}/>
						</li>
						<li htmlFor="country">
						  <select onChange={this.inputQuery} name="country" id="country" style={{ marginTop: '10%' }}>
							<option>Select user country</option>
							<RegionListEditor current={ pi.region }/>
						  </select>
						</li>
					  </ul>
					</li>
				  </ul>
				</div>
				<div data-cont="footer">
				  <button type="submit" className="add-but">Update admin portal user</button>
				  <button type="button" className="add-but" style={{ display: 'block', backgroundColor: 'red'}}>Delete current user</button>
				</div>
			  </form>
			</React.Fragment>
		);
	}
}

function objectifyForm(formArray) {
    //serialize data function
    var returnArray = {};
    for (var i = 0; i < formArray.length; i++){
        returnArray[formArray[i]['name']] = formArray[i]['value'];
    }
    return returnArray;
}
const AddEvent = (e) => {
	e.preventDefault();
	let fda = new FormData(),
		alertError = '',
		fq =  {
			parameters: {
				fn: sessionStorage.getItem('queryPublic-firstname'),
				sn: sessionStorage.getItem('queryPublic-surname'),
				login: sessionStorage.getItem('queryPublic-login'),
				mail: sessionStorage.getItem('queryPublic-email'),
				pwd: sessionStorage.getItem('queryPublic-password'),
				region: sessionStorage.getItem('queryPublic-country'),
				phone: sessionStorage.getItem('queryPublic-phone')
			}
		};
		
		fda.append('svcQuery', JSON.stringify(fq));
		
		fetch('/admin/api/dataServices/filters/servicesPortalUsers/send', { method: 'POST', body: fda}).then((response) => {
			if(response.status === 200){ window.location.assign('/admin?svc=portalUsers&subSVC=list'); }
		}).catch(error => {
			alert('Response error!');
			console.log(error);
		});
	
	if(alertError){ alert(alertError); }
}
const EditEvent = (e) => {
	e.preventDefault();
	let fde = new FormData(),
		alertErrorE = '',
		fqe =  {
			login: params['login'],
			parameters: {
				fn: sessionStorage.getItem('queryPublic-firstname'),
				sn: sessionStorage.getItem('queryPublic-surname'),
				login: sessionStorage.getItem('queryPublic-login'),
				mail: sessionStorage.getItem('queryPublic-email'),
				pwd: sessionStorage.getItem('queryPublic-password'),
				region: sessionStorage.getItem('queryPublic-country'),
				phone: sessionStorage.getItem('queryPublic-phone')
			}
		};
		
	
		
		fde.append('svcQuery', JSON.stringify(fqe));
		
		fetch('/admin/api/dataServices/filters/servicesPortalUsers/update', { method: 'POST', body: fde}).then((response) => {
			if(response.status === 200){ window.location.assign('/admin?svc=portalUsers&subSVC=list'); }
		}).catch(error => {
			alert('Response error!');
			console.log(error);
		});
	
	if(alertErrorE){ alert(alertErrorE); }
}
const DeleteEvent = (e,t) => {
	e.preventDefault();
	let fdd = new FormData(),
		fqd = { login: params['login'] };
		
	fdd.append('svcQuery', JSON.stringify(fqd));
	
	fetch('/admin/api/dataServices/filters/servicesPortalUsers/delete', { method: 'POST', body: fdd}).then((response) => {
			if(response.status === 200){ window.location.assign('/admin?svc=portalUsers&subSVC=list'); }
		}).catch(error => {
			alert('Response error!');
			console.log(error);
		});
}

const HeaderRender = (hash) => {
  let render = '';
  switch(hash){
    case "add": render = '<a href="/admin?svc=portalUsers&subSVC=list">Back to list</a>'; break;
	case "edit": render = '<a href="/admin?svc=portalUsers&subSVC=list">Back to list</a>'; break;
	case "delete": render = '<a href="/admin?svc=portalUsers&subSVC=list">Back to list</a>'; break;
	case "list": render = '<a href="/admin?svc=portalUsers&subSVC=add">Add new user</a>'; break;
  }
  
   $('.data-page > header nav').html(render);
}
const UXRender = (hash) => {
  switch(hash){
    case "add": ReactDOM.render(<Add />, document.getElementById('cms-service')); break;
    case "edit": ReactDOM.render(<Edit />, document.getElementById('cms-service')); break;
    case "delete": ReactDOM.render(<Delete />, document.getElementById('cms-service')); break;
  }
}

$(document).ready(function(){
	let s = params['subSVC'];
		
	HeaderRender(s);
	UXRender(s);
	
	$('.admin-list-table tbody tr').click(function(e,t){
		let currentUser = $(this).index() + 1,
			currentData = $('.admin-list-table tbody tr:nth-child(' + currentUser + ') td:nth-child(2)').text();
			
		window.location.assign('/admin?svc=portalUsers&subSVC=edit&login=' + currentData);
	});
});
