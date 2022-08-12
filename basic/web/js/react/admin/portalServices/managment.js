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
		  country: [],
		  region: []
	    };
	}
	componentDidMount(){
		if(this.props.type === 'region'){
			fetch('/services/3/get', { method: 'GET' })
			.then(response => response.json())
			.then(data => this.setState({ region: data }))
			.catch(error => {
				alert('Response error!');
				console.log(error);
			});
		}
		else{
			fetch('/services/0/get', { method: 'GET' })
			.then(response => response.json())
			.then(data => this.setState({ country: data }))
			.catch(error => {
				alert('Response error!');
				console.log(error);
			});
		}
	}
	render(){
		let myStates;
		if(this.props.type === 'region'){
			myStates = this.state.region.map((myState) =>
				<option value={myState.city + '/' + myState.region + '/' + myState.country}>{ myState.title }</option>
			);
		}
		else{
			myStates = this.state.country.map((myState) =>
				<option value={myState.code}>{ myState.title }</option>
			);
		}
		
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
		  country: [],
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
		let myStates;
		if(this.props.type === 'region'){
			myStates = this.state.region.map((myState) =>
				<option value={myState.city + '/' + myState.region + '/' + myState.country}>{ myState.title }</option>
			);
		}
		else{
			myStates = this.state.country.map((myState) =>
				<option value={myState.code}>{ myState.title }</option>
			);
		}
		
		return (
			<React.Fragment>
			  {myStates}
			</React.Fragment>
		);
	}
}

class CategoryList extends React.Component{
	constructor(props){
		super(props);
		this.state = {
		  category: []
	    };
	}
	componentDidMount(){
		fetch('/admin/api/dataServices/filters/portalServicesCategory/show', { method: 'GET' })
        .then(response => response.json())
		.then(data => this.setState({ category: data }))
		.catch(error => {
			alert('Response error!');
			console.log(error);
		});
	}
	render(){
		const myStates = this.state.category.map((myState) =>
			<option value={myState.id}>{ myState.name }</option>
		);
		return (
			<React.Fragment>
			  {myStates}
			</React.Fragment>
		);
	}
}

function serviceEditorQuery(){
	var fqd = new FormData();
	fqd.append('svcQuery', $('#ready-query').val());
	
	return fqd;
}
function serviceEditorBuilder(q){
	if(params['contentStatus'] === 'true'){
		let newService = {
			query: {
				title: q.title,
				head: q.meta,
				body: q.content,
				footer: q.proc
			}
		};

		$('#ready-query').val(JSON.stringify(newService));
	}
	else{
		let newCategory = {
			query: {
				title: q.title,
				iconBlob: q.icon
			}
		};
		$('#ready-query').val(JSON.stringify(newCategory));
	}
}

function serviceEditorUpdater(q){
	if(params['contentStatus']){
		let updateService = {
			query: {
				id: params['id'],
				head: q.meta,
				body: q.content,
				footer: q.proc
			}
		};

		
		$('#ready-query').val(JSON.stringify(updateService));
	}
	else{
		let updateCategory = {
			query: {
				id: params['id'],
				title: q.title,
				iconBlob: q.icon
			}
		};
		$('#ready-query').val(JSON.stringify(updateCategory));
	}
}
    
class Add extends React.Component{
	constructor(props){
		super(props);
		this.state = { currentType: params['contentStatus'] };
	}
	componentDidMount(){
		if(this.state.currentType === 'true'){
			CKEDITOR.replace('description', { width: $('.wf > .editor-component').css('width') });
			CKEDITOR.replace('terms', { width: $('.wf > .editor-component').css('width') });
			
			$('.add-questions > main button').click(addQuestionFields);
			$('.add-formElements > main button').click(addFormStepFields);
			
			$('#service-editor > button#send').click(function(){
				let validErrorAdd = '',
					faqQuery = [],
					stepQuery = [],
					queryReadyData = {
						title: '',
						meta: {
							seoData: {
								categoryId: 0,
								region: {
									country: null,
									region: null
								},
								description: '',
								term: '',
								faqService: {}
							},
							accessRole: 'private',
						},
						content: {
							form: {}
						},
						proc: {
							send: '',
							push: '',
							realtime: '',
							control: ''
						}
					};

				if($('#service-editor > *[data-block=\'name\'] input#title').val() !== ''){ queryReadyData.title = $('#service-editor > *[data-block=\'name\'] input#title').val(); }
				else{ validErrorAdd += 'Service title is required\n'; }

				if($('#service-editor > *[data-block=\'content\'] ul[data-group=\'meta\'] li nav .wf select').val() !== 'any'){ queryReadyData.meta.seoData.categoryId = $('#service-editor > *[data-block=\'content\'] ul[data-group=\'meta\'] li nav .wf select').val(); }
				else{ validErrorAdd += 'Service category is required\n'; }

				if($('#service-editor > *[data-block=\'content\'] ul[data-group=\'meta\'] li nav .wf .level li #accessLevel').val() !== 'private'){ queryReadyData.meta.accessRole = $('#service-editor > *[data-block=\'content\'] ul[data-group=\'meta\'] li nav .wf .level li #accessLevel').val(); }
				
				if(CKEDITOR.instances.terms.getData() !== ''){ queryReadyData.meta.seoData.term = CKEDITOR.instances.terms.getData(); }
				if(CKEDITOR.instances.description.getData() !== ''){ queryReadyData.meta.seoData.description = CKEDITOR.instances.description.getData(); }
				
				for(let i = 0; i < localStorage.length; i++){
					let currentKey = localStorage.key(i);
					if(currentKey === 'faq'){ faqQuery.push(JSON.parse(localStorage.getItem(currentKey))); }
					else if(currentKey === 'fields'){ stepQuery.push(JSON.parse(localStorage.getItem(currentKey))); }
				}
				
				queryReadyData.meta.seoData.faqService = faqQuery;
				queryReadyData.content.form = stepQuery;
				
				if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(3).val() !== ''){ queryReadyData.proc.control = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(3).val(); }
				if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(2).val() !== ''){ queryReadyData.proc.realtime = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(2).val(); }
				if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(0).val() !== ''){ queryReadyData.proc.send = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(0).val(); }
				if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(1).val() !== ''){ queryReadyData.proc.push = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(1).val(); }

				
				
				if(validErrorAdd !== ''){ alert(validErrorAdd); }
				else{
					serviceEditorBuilder(queryReadyData);

					fetch('/admin/api/dataServices/filters/portalServices/send',{method: 'POST', body: serviceEditorQuery()})
					.then((response) => {
						if (response.status === 200) { window.location.assign('/admin?svc=dataManagment&subSVC=portalServices'); } 
						else { alert('Service content adding failed!'); }
					})
					.catch(error => {
						alert('Response error!');
						console.log(error);
					});
				}
				
			});
		}
		else{
			$('#titleImageU').change(function(e){
				const file = e.target.files[0];
	
				const reader = new FileReader();
				reader.onloadend = () => {
					sessionStorage.setItem('blobReady', reader.result);
					$('#uploaded').attr('src', reader.result);
				};
				reader.readAsDataURL(file);
			});

			$('#add-category > button').click(function(){
				let crq = {
					title: $('#add-category > div input#theme').val(),
					icon: $('#uploaded').attr('src')
				};

				serviceEditorBuilder(crq);

				fetch('/admin/api/dataServices/filters/portalServicesCategory/send',{method: 'POST', body: serviceEditorQuery()})
					.then((response) => {
						if (response.status === 200) { window.location.assign('/admin?svc=dataManagment&subSVC=portalServices'); } 
						else { alert('Service category adding failed!'); }
					})
					.catch(error => {
						alert('Response error!');
						console.log(error);
					});
			});
		}
	}
	render(){
		return this.renderDynamicForm(this.state.currentType);
	}
	inputCountryQuery(e,t){}
	inputRegionQuery(e,t){}
	renderDynamicForm(q){
		
		if(q === 'true'){
			return (
				<React.Fragment>
					<input type="hidden" id="ready-query" name="ready-query" value="" />
					<section id="service-editor">
						<header data-block="name">
							<input type="text" id="title" placeholder="Input service name" />
						</header>
						<main data-block="content">
							<h3>Service meta data</h3>
							<ul data-group="meta">
								<li>
									{/*SEO Data*/}
									<nav>
										<div className="wf">
											<h4>Select the category</h4>
											<select id="categorySelector">
												<option value="any">Any category</option>
												<CategoryList />
											</select>
										</div>
										<div className="wf">
											<h4>Input the region</h4>
											<div id="regionSelector">
												<select onChange={this.inputCountryQuery} name="country" id="country">
													<option>Select your country</option>
													<RegionList type="country" />
												</select>
												<select onChange={this.inputRegionQuery} name="region" id="region">
													<option>Select country</option>
													<RegionList type="region" />
												</select>
											</div>
										</div>
										<div className="wf">
											<h4>Input service description</h4>
											<textarea className="editor-component" id="description" name="description"></textarea>
										</div>
									</nav>
								</li>
								<li>
									{/*Security*/}
									<nav>
										<div className="wf">
											<h4>Select one access level:</h4>
											<ul className="level">
												<li>
													<input type="radio" id="accessLevel" value="private" />
													<span>For registred users</span>
												</li>
												<li>
													<input type="radio" id="accessLevel" value="public" />
													<span>For all users and visitors</span>
												</li>
											</ul>
										</div>
									</nav>
								</li>
							</ul>

							<h3>Service page content</h3>
							<ul data-group="content">
								<li>
									{/*Text Data*/}
									<nav>
										<div className="wf">
											<h4>Input service term:</h4>
											<textarea className="editor-component" id="terms" name="terms"></textarea>
										</div>
										<div className="wf">
											<h4>Adding service questions:</h4>
											<div className="add-questions">
												<header>
													<div>
														<input type="text" id="question" placeholder="Input service FAQ question" />
														<textarea className="editor-component" placeholder="Input service answer for FAQ question" id="answer" name="answer"></textarea>
													</div>
												</header>
												<main><button>Add question</button></main>
											</div>
										</div>
									</nav>
								</li>
								<li>
									{/*Form Data*/}
									<nav>
										<div className="wf">
											<h4>Adding form elements</h4>
											<div className="add-formElements">
												<header>
													<div>
														<input type="text" name="field" id="field" placeholder="Enter the field name" />
														<select name="fieldType" id="fieldType">
															<option>Select form field type</option>
															<option value="default">Text form</option>
															<option value="list">List form</option>
															<option value="upload">Files upload form</option>
															<option value="search">Search form</option>
															<option value="queryContent">Query from content</option>
														</select>
													</div>
												</header>
												<main><button>Add element</button></main>
											</div>
										</div>
									</nav>
								</li>
							</ul>
						</main>
						<footer data-block="automatization">
							<ul>
								<li>
									<h4>Sender command:</h4>
									<input type="text" name="senderCmd" id="senderCmd" />
								</li>
								<li>
									<h4>Push command:</h4>
									<input type="text" name="pushCmd" id="pushCmd" />
								</li>
								<li>
									<h4>Realtime command:</h4>
									<input type="text" name="realtimeCmd" id="realtimeCmd" />
								</li>
								<li>
									<h4>Control command:</h4>
									<input type="text" name="controlCmd" id="controlCmd" />
								</li>
							</ul>
						</footer>
						<button id="send">Send service to portal</button>
					</section>
				</React.Fragment>
			);
		}
		else{
			return (
				<React.Fragment>
					<input type="hidden" id="ready-query" name="ready-query" value="" />
					<div id="add-category">
						<div>
							<h2>Please, input services category(only English)</h2>
							<input type="text" id="theme" />
						</div>
						<div>
							<h2>Upload category icon</h2>
							<section data-block="titleImage">
								<label htmlFor="titleImageU"><input type="file" name="titleImageU" id="titleImageU" accept="image/*" />Upload icon</label>
								<img src="https://img.icons8.com/ios/50/undefined/not-applicable.png" id="uploaded" />
							</section>
						</div>
						<button>Insert category</button>
				</div>
			</React.Fragment>
			);
		}
	}
}

class Edit extends React.Component{
	constructor(props){
		super(props);
		this.state = { 
			currentType: params['contentStatus'],
			currentQuery: [],
			readyQuery: new FormData()
		};
	}
	componentDidMount(){
		if(this.state.currentType === 'true'){
			this.state.readyQuery.append('id', params['id']);
			
			fetch('/admin/api/dataServices/filters/portalServices/show', { method: 'GET', body: this.state.readyQuery})
				.then(response => response.json())
				.then(data => this.setState({ currentQuery: data }));
			
			CKEDITOR.replace('description', { width: $('.wf > .editor-component').css('width') });
			CKEDITOR.replace('terms', { width: $('.wf > .editor-component').css('width') });
			
			let validErrorEdit = '';
			queryReadyData = {
					title: '',
					meta: {
						seoData: {
							categoryId: 0,
							region: {
								country: null,
								region: null
							},
							description: '',
							term: '',
							faqService: {}
						},
						accessRole: 'private',
					},
					content: {
						form: {}
					},
					proc: {
						send: '',
						push: '',
						realtime: '',
						control: ''
					}
			};

			if($('#service-editor > *[data-block=\'name\'] input#title').val() !== ''){ queryReadyData.title = $('#service-editor > *[data-block=\'name\'] input#title').val(); }
			else{ validErrorEdit += 'Service title is required\n'; }

			if($('#service-editor > *[data-block=\'content\'] ul[data-group=\'meta\'] li nav .wf select').val() !== 'any'){ queryReadyData.meta.seoData.categoryId = $('#service-editor > *[data-block=\'content\'] ul[data-group=\'meta\'] li nav .wf select').val(); }
			else{ validErrorEdit += 'Service category is required\n'; }

			if($('#service-editor > *[data-block=\'content\'] ul[data-group=\'meta\'] li nav .wf .level li #accessLevel').val() !== 'private'){ queryReadyData.meta.accessRole = $('#service-editor > *[data-block=\'content\'] ul[data-group=\'meta\'] li nav .wf .level li #accessLevel').val(); }

			if(CKEDITOR.instances.terms.getData() !== ''){ queryReadyData.meta.seoData.term = CKEDITOR.instances.terms.getData(); }
			if(CKEDITOR.instances.description.getData() !== ''){ queryReadyData.meta.seoData.description = CKEDITOR.instances.description.getData(); }
				
			if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(3).val() !== ''){ queryReadyData.proc.control = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(3).val(); }
			if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(2).val() !== ''){ queryReadyData.proc.realtime = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(2).val(); }
			if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(0).val() !== ''){ queryReadyData.proc.send = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(0).val(); }
			if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(1).val() !== ''){ queryReadyData.proc.push = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(1).val(); }

			if(validErrorEdit !== ''){ alert(validErrorEdit); }
			else{
				serviceEditorUpdater(queryReadyData);

				$('#service-editor > button#send').click(function(){
					fetch('/admin/api/dataServices/filters/portalServices/update',{method: 'POST', body: serviceEditorQuery()})
						.then((response) => {
							if (response.status === 200) { window.location.assign('/admin?svc=dataManagment&subSVC=portalServices'); } 
							else { alert('Service content update failed!'); }
						})
						.catch(error => {
							alert('Response error!');
							console.log(error);
						});
				});
			}
		}
		else{
			$('#titleImageU').change(function(e){
				const file = e.target.files[0];
	
				const reader = new FileReader();
				reader.onloadend = () => {
					sessionStorage.setItem('blobReadyNewVersion', reader.result);
					$('#uploaded').attr('src', reader.result);
				};
				reader.readAsText(file);
			});

			$('#add-category > button').click(function(){
				let crq = {
					title: sessionStorage.getItem('currentCategoryUpdate') || $('#add-category > div input#theme').val(),
					icon: sessionStorage.getItem('blobReadyNewVersion') || sessionStorage.getItem('blobReady')
				};
	
				serviceEditorUpdater(crq);

				fetch('/admin/api/dataServices/filters/portalServicesCategory/update',{method: 'POST', body: serviceEditorQuery()})
					.then((response) => {
						if (response.status === 200) { 
							sessionStorage.removeItem('blobReadyNewVersion');
							sessionStorage.removeItem('blobReady');
							sessionStorage.removeItem('currentCategoryUpdate');

							window.location.assign('/admin?svc=dataManagment&subSVC=portalServices'); 
						} 
						else { alert('Service category update failed!'); }
					})
					.catch(error => {
						alert('Response error!');
						console.log(error);
					});
			});
		}
	}
	render(){
		return this.renderDynamicForm(this.state.currentType, this.state.currentQuery);
	}
	inputCountryQuery(e,t){}
	inputRegionQuery(e,t){}
	renderDynamicForm(q, i){
		
		if(q === 'true'){
			
			const responseStateInfo = i.faq.map((response) => {
				(
					<div>
						<input type="text" id="question" value={ response.question } />
						<textarea className="editor-component" id="answer" name="answer">{ response.answer }</textarea>
						<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAABmJLR0QA/wD/AP+gvaeTAAACSklEQVRoge2aTWobMRiGn6/4KM4JUt+ji4ZQMNS7uIvkMt04e6cldJN7mJ7AvkjBjrrITDDFWPqkV/KiejaBMDOvHg+jv0/Q6XQ6nU7nUpj3huvH3ScL4TtAMLv/fTd90TerXr5L+Ppxe2OBH8Bk+NfBYLFZXq09z8lFkZ8sfCJspIm0Kj9J+ExYVqgXZX5UePhmfp0JG9kbNt8sp8+xZ3qYrXa3gbBOyQ9mN7Fv+kMscOggYmEAk0BYz1a724Rrk3DIAkzGzuwcUWEnMmmn7EiIXRAVDmb3wN4RWiydKbsPZg+xi6LCwzfxBb/002y1nTvuAd46qAzZgwUWKWNy8rD0cbX9DPx0N8TReyf0xqczAl83366eUi52TTxqSreQhYypZQ3pVrKQIQxa6ZaykCkMGunWslAgDGXSr8af1rJQKAz5Y+bw13WPYupaLAzZb9pD8ZsdkQhDVWmZLAiFoYq0VBbEwiCVlstCBWGQSFeRhUrCUCRdTRb06+F3ghX8mCX3Rh9dgcwZ1DHV9sjkwgLZkSrSUmGh7IhcWiZcQXZEKi0Rrig7IpP+7xYPRcNSyYYbDTcGj8l+w4rFe4uNwX/JElbuVLSWzqgP67dlWkqX1ofTGpYwN24lragPn2+QYyHQQlpVHz7dkIxVT21pZX34mKIxs6CY1rQ+/B5cOkHYLKfPhs1xjtOXqA/LTgFkSjetD8uPPDilm9aHDxZYqM93wJt0an6r+nDVPSh1fml9uImsMr/k6GEIZg8XPHp4kfxOp9PpdDr5/AUtRwPaP+ABuAAAAABJRU5ErkJggg==" alt="Delete current question" />
					</div>
				)
			});
			
			const responseStateData = i.form.map((response) => {
				(
					<div>
						<input type="text" name="field" id="field" placeholder="Enter the field name" value={ i.name } />
						<select name="fieldType" id="fieldType">
							<option>Select form field type</option>
							<option value="default" { i.field === 'default' ? 'selected' }>Text form</option>
							<option value="list" { i.field === 'list' ? 'selected' }>List form</option>
							<option value="upload" { i.field === 'upload' ? 'selected' }>Files upload form</option>
							<option value="search" { i.field === 'search' ? 'selected' }>Search form</option>
							<option value="queryContent" { i.field === 'queryContent' ? 'selected' }>Query from content</option>
						</select>
						<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAABmJLR0QA/wD/AP+gvaeTAAACSklEQVRoge2aTWobMRiGn6/4KM4JUt+ji4ZQMNS7uIvkMt04e6cldJN7mJ7AvkjBjrrITDDFWPqkV/KiejaBMDOvHg+jv0/Q6XQ6nU7nUpj3huvH3ScL4TtAMLv/fTd90TerXr5L+Ppxe2OBH8Bk+NfBYLFZXq09z8lFkZ8sfCJspIm0Kj9J+ExYVqgXZX5UePhmfp0JG9kbNt8sp8+xZ3qYrXa3gbBOyQ9mN7Fv+kMscOggYmEAk0BYz1a724Rrk3DIAkzGzuwcUWEnMmmn7EiIXRAVDmb3wN4RWiydKbsPZg+xi6LCwzfxBb/002y1nTvuAd46qAzZgwUWKWNy8rD0cbX9DPx0N8TReyf0xqczAl83366eUi52TTxqSreQhYypZQ3pVrKQIQxa6ZaykCkMGunWslAgDGXSr8af1rJQKAz5Y+bw13WPYupaLAzZb9pD8ZsdkQhDVWmZLAiFoYq0VBbEwiCVlstCBWGQSFeRhUrCUCRdTRb06+F3ghX8mCX3Rh9dgcwZ1DHV9sjkwgLZkSrSUmGh7IhcWiZcQXZEKi0Rrig7IpP+7xYPRcNSyYYbDTcGj8l+w4rFe4uNwX/JElbuVLSWzqgP67dlWkqX1ofTGpYwN24lragPn2+QYyHQQlpVHz7dkIxVT21pZX34mKIxs6CY1rQ+/B5cOkHYLKfPhs1xjtOXqA/LTgFkSjetD8uPPDilm9aHDxZYqM93wJt0an6r+nDVPSh1fml9uImsMr/k6GEIZg8XPHp4kfxOp9PpdDr5/AUtRwPaP+ABuAAAAABJRU5ErkJggg==" alt="Delete current field" />
					</div>
				)
			});
			
			return (
				<React.Fragment>
				    <input type="hidden" id="ready-query" name="ready-query" value="" />
				    <section id="service-editor">
						<header data-block="name">
							<input type="text" id="title" placeholder="Input service name" value={ i.title }/>
						</header>
						<main data-block="content">
							<h3>Service meta data</h3>
							<ul data-group="meta">
								<li>
									{/*SEO Data*/}
									<nav>
										<div className="wf">
											<h4>Select the category</h4>
											<select id="categorySelector">
												<option value="any">Any category</option>
												<CategoryListEditor current={ i.categoryId }/>
											</select>
										</div>
										<div className="wf">
											<h4>Input the region</h4>
											<div id="regionSelector">
												<select onChange={this.inputCountryQuery} name="country" id="country">
													<option>Select your country</option>
													<RegionListEditor type="country" current={ i.region.country }/>
												</select>
												<select onChange={this.inputRegionQuery} name="region" id="region">
													<option>Select country</option>
													<RegionListEditor type="region" current={ i.region.data }/>
												</select>
											</div>
										</div>
										<div className="wf">
											<h4>Input service description</h4>
											<textarea className="editor-component" id="description" name="description">{ i.description }</textarea>
										</div>
									</nav>
								</li>
								<li>
									{/*Security*/}
									<nav>
										<div className="wf">
											<h4>Select one access level:</h4>
											<ul className="level">
												<li>
													<input type="radio" id="accessLevel" value="private" { i.accessLevel === 'Private' ? 'checked' }/>
													<span>For registred users</span>
												</li>
												<li>
													<input type="radio" id="accessLevel" value="public" { i.accessLevel === 'Public' ? 'checked' }/>
													<span>For all users and visitors</span>
												</li>
											</ul>
										</div>
									</nav>
								</li>
							</ul>

							<h3>Service page content</h3>
							<ul data-group="content">
								<li>
									{/*Text Data*/}
									<nav>
										<div className="wf">
											<h4>Input service term:</h4>
											<textarea className="editor-component" id="terms" name="terms">{ i.terms }</textarea>
										</div>
										<div className="wf">
											<h4>Adding service questions:</h4>
											<div className="add-questions">
												<header>{ responseStateInfo }</header>
												<main><button>Add question</button></main>
											</div>
										</div>
									</nav>
								</li>
								<li>
									{/*Form Data*/}
									<nav>
										<div className="wf">
											<h4>Adding form elements</h4>
											<div className="add-formElements">
												<header>{ responseStateData }</header>
												<main><button>Add element</button></main>
											</div>
										</div>
									</nav>
								</li>
							</ul>
						</main>
						<footer data-block="automatization">
							<ul>
								<li>
									<h4>Sender command:</h4>
									<input type="text" name="senderCmd" id="senderCmd" value={ i.proc.send }/>
								</li>
								<li>
									<h4>Push command:</h4>
									<input type="text" name="pushCmd" id="pushCmd" value={ i.proc.push }/>
								</li>
								<li>
									<h4>Realtime command:</h4>
									<input type="text" name="realtimeCmd" id="realtimeCmd" value={ i.proc.realtime }/>
								</li>
								<li>
									<h4>Control command:</h4>
									<input type="text" name="controlCmd" id="controlCmd" value={ i.proc.control }/>
								</li>
							</ul>
						</footer>
						<button id="send">Update current service in portal</button>
						<button id="delete">Delete current service in portal</button>
					</section>
				</React.Fragment>
			);
		}
		else{
			return (
				<React.Fragment>
				    <input type="hidden" id="ready-query" name="ready-query" value="" />
				    <div id="add-category">
						<div>
							<h2>Please, input services category(only English)</h2>
							<input type="text" id="theme" />
						</div>
						<div>
							<h2>Upload category icon</h2>
							<section data-block="titleImage">
								<label htmlFor="titleImageU"><input type="file" name="titleImageU" id="titleImageU" accept="image/*" />Upload icon</label>
								<img src="" id="uploaded" />
							</section>
						</div>
						<button>Update category</button>
						<button id="delete">Delete category</button>
				    </div>
			  </React.Fragment>
			);
		}
		
	}
}

const HeaderRender = (hash) => {
  let render = "";
  switch(hash){
    case "#add": render = '<a href="/admin?svc=dataManagment&subSVC=portalServices">Back to list</a>'; break;
    case "#edit": render = '<a href="/admin?svc=dataManagment&subSVC=portalServices">Back to list</a>'; break;
  }
  
  $('.data-page > header nav').html(render);
}
const UIRender = (hash) => {
  switch(hash){
    case "#add": document.title = "Add new Service"; break;
    case "#edit": document.title = "Edit current Service"; break;
  }
}
const UXRender = (hash) => {
  switch(hash){
    case "#add": ReactDOM.render(<Add />, document.querySelector('.data-page > main')); break;
    case "#edit": ReactDOM.render(<Edit />, document.querySelector('.data-page > main')); break;
  }
}

const resetForm = (f) => {
	$(f + ' > header div input').val('');
	$(f + ' > header div select option:selected').remove();
	$(f + ' > header div textarea').val('');
}


const addQuestionFields = (e,t) => {
	let questionQuery = null,
		answerQuery = null;
		
	if($('.add-questions > header div #question').val() !== null){ questionQuery = $('.add-questions > header div #question').val(); }
	else{ alert('Question is required!'); }
	
	if($('.add-questions > header div #answer').val() !== null){ answerQuery = $('.add-questions > header div #answer').val(); }
	else{ alert('Answer is required!'); }
		
	if(questionQuery && answerQuery){
		
		let qaq = {
			question: questionQuery,
			answer: answerQuery
		};
			
		localStorage.setItem('faq', JSON.stringify(qaq));
		resetForm('.add-questions');
	}
}
const addFormStepFields = (e,t) => {
	let fnQuery = null,
		ftQuery = null;
		
		
	if($('.add-formElements > header div #field').val() !== null){ fnQuery = $('.add-formElements > header div #field').val(); }
	else{ alert('Field name is required!'); }
	
	if($('.add-formElements > header div #fieldType').val() !== null){ ftQuery = $('.add-formElements > header div #fieldType').val(); }
	else{ alert('Field type is required!'); }
		
	if(fnQuery && ftQuery){
		
		let fq = {
			field: fnQuery,
			type: ftQuery
		};
			
		localStorage.setItem('fields', JSON.stringify(fq));
		resetForm('.add-formElements');
	}
}
const updateQuestionFields = (e,t) => {
	
}
const updateFormStepFields = (e,t) => {
	
}



$('.data-page > header h2').html(document.title);

$(document).ready(function(){
	$(window).on('hashchange',function(){
		let s = window.location.hash;
		
		HeaderRender(s);
		UIRender(s);
		UXRender(s);
	}).trigger('hashchange');
	
});
