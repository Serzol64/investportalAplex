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

function serviceEditorQuery(){
	var fqd = new FormData();
	fqd.append('svcQuery', $('#ready-query').val());
	
	return fqd;
}
function serviceEditorBuilder(q){
	if(params['contentStatus']){
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
		if(this.state.currentType){
			$('#service-editor > button#send').click(function(){
				let validErrorAdd = '';
				let queryReadyData = {
					title: '',
					meta: {
						seoData: {
							categoryId: 0,
							description: '',
							term: '',
							faqService: {}
						},
						accessRole: 'private',
					},
					content: {
						form: {},
						validator: {}
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
				
				if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(3).val() !== ''){ queryReadyData.proc.control = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(3).val(); }
				if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(2).val() !== ''){ queryReadyData.proc.realtime = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(2).val(); }
				if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(0).val() !== ''){ queryReadyData.proc.sender = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(0).val(); }
				if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(1).val() !== ''){ queryReadyData.proc.push = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(1).val(); }

				
				
				if(validErrorAdd !== ''){ alert(validErrorAdd); }
				else{
					serviceEditorBuilder(queryReadyData);

					fetch('/admin/api/dataServices/filters/portalServices/send',{method: 'POST', body: serviceEditorQuery()})
					.then((response) => {
						if (response.status === 200) { window.location.assign('/admin?svc=adminUsers&subSVC=portalServices'); } 
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
				reader.readAsText(file);
			});

			$('#add-category > button').click(function(){
				let crq = {
					title: $('#add-category > div input#theme').val(),
					icon: sessionStorage.getItem('blobReady')
				};

				serviceEditorBuilder(crq);

				fetch('/admin/api/dataServices/filters/portalServicesCategory/send',{method: 'POST', body: serviceEditorQuery()})
					.then((response) => {
						if (response.status === 200) { 
							sessionStorage.removeItem('blobReady');
							window.location.assign('/admin?svc=adminUsers&subSVC=portalServices'); 
						} 
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
		return (
			<React.Fragment>{ this.renderDynamicForm(this.state.currentType) }</React.Fragment>
		);
	}
	renderDynamicForm(q){
		let dr = null; 
		
		if(q){
			dr = (
				<><input type="hidden" id="ready-query" name="ready-query" value="" /><section id="service-editor">
					<header data-block="name">
						<input type="text" id="title" placeholder="Input service name" />
					</header>
					<main data-block="content">
						<h3>Service meta data</h3>
						<ul data-group="meta">
							<li>
								{"<!--SEO Data-->"}
								<nav>
									<div className="wf">
										<h4>Select the category</h4>
										<select id="categorySelector">
											<option value="any">Any category</option>
										</select>
									</div>
									<div className="wf">
										<h4>Input service description</h4>
										<textarea className="editor-component" id="description" name="description"></textarea>
									</div>
								</nav>
							</li>
							<li>
								{"<!--Security-->"}
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
								{"<!--Text Data-->"}
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
													<input type="text" id="question" value="Input service FAQ question" />
													<textarea className="editor-component" id="answer" name="answer"></textarea>
												</div>
											</header>
											<main><button>Add question</button></main>
										</div>
									</div>
								</nav>
							</li>
							<li>
								{"<!--Form Data-->"}
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
														<option value="upload">File uploader</option>
														<option value="search">Search form</option>
													</select>
												</div>
											</header>
											<main><button>Add element</button></main>
										</div>
									</div>
								</nav>
							</li>
							<li>
								{"<!--Validator Data-->"}
								<nav>
									<div className="wf">
										<h4>Adding form validation errors</h4>
										<div className="add-validator">
											<header>

											</header>
											<main><button>Add validation data</button></main>
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
				</section></>
			);
		}
		else{
			dr = (
				<><input type="hidden" id="ready-query" name="ready-query" value="" /><div id="add-category">
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
					<button>Insert category</button>
				</div></>
			);
		}
		
		return dr;
	}
}

class Edit extends React.Component{
	constructor(props){
		super(props);
		this.state = { 
			currentType: params['contentStatus'],
			currentQuery: []
		};
	}
	componentDidMount(){
		if(this.state.currentType){

			let validErrorEdit = '';
			queryReadyData = {
					title: '',
					meta: {
						seoData: {
							categoryId: 0,
							description: '',
							term: '',
							faqService: {}
						},
						accessRole: 'private',
					},
					content: {
						form: {},
						validator: {}
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
			if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(0).val() !== ''){ queryReadyData.proc.sender = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(0).val(); }
			if($('#service-editor > *[data-block=\'automatization\'] ul li input').eq(1).val() !== ''){ queryReadyData.proc.push = $('#service-editor > *[data-block=\'automatization\'] ul li input').eq(1).val(); }

			if(validErrorEdit !== ''){ alert(validErrorEdit); }
			else{
				serviceEditorUpdater(queryReadyData);

				$('#service-editor > button#send').click(function(){
					fetch('/admin/api/dataServices/filters/portalServices/update',{method: 'POST', body: serviceEditorQuery()})
						.then((response) => {
							if (response.status === 200) { window.location.assign('/admin?svc=adminUsers&subSVC=portalServices'); } 
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

				fetch('/admin/api/dataServices/filters/portalServicesCategory/send',{method: 'POST', body: serviceEditorQuery()})
					.then((response) => {
						if (response.status === 200) { 
							sessionStorage.removeItem('blobReadyNewVersion');
							sessionStorage.removeItem('blobReady');
							sessionStorage.removeItem('currentCategoryUpdate');

							window.location.assign('/admin?svc=adminUsers&subSVC=portalServices'); 
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
		return (
			<React.Fragment>{ this.renderDynamicForm(this.state.currentType, this.state.currentQuery) }</React.Fragment>
		);
	}
	renderDynamicForm(q, i){
		let dr = null; 
		
		if(q){
			dr = (
				<><input type="hidden" id="ready-query" name="ready-query" value="" /><section id="service-editor">
					<header data-block="name">
						<input type="text" id="title" placeholder="Input service name" />
					</header>
					<main data-block="content">
						<h3>Service meta data</h3>
						<ul data-group="meta">
							<li>
								{"<!--SEO Data-->"}
								<nav>
									<div className="wf">
										<h4>Select the category</h4>
										<select id="categorySelector">
											<option value="any">Any category</option>
										</select>
									</div>
									<div className="wf">
										<h4>Input service description</h4>
										<textarea className="editor-component" id="description" name="description"></textarea>
									</div>
								</nav>
							</li>
							<li>
								{"<!--Security-->"}
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
								{"<!--Text Data-->"}
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
													<input type="text" id="question" value="Input service FAQ question" />
													<textarea className="editor-component" id="answer" name="answer"></textarea>
												</div>
											</header>
											<main><button>Add question</button></main>
										</div>
									</div>
								</nav>
							</li>
							<li>
								{"<!--Form Data-->"}
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
														<option value="upload">File uploader</option>
														<option value="search">Search form</option>
													</select>
												</div>
											</header>
											<main><button>Add element</button></main>
										</div>
									</div>
								</nav>
							</li>
							<li>
								{"<!--Validator Data-->"}
								<nav>
									<div className="wf">
										<h4>Adding form validation errors</h4>
										<div className="add-validator">
											<header>
												<div>
												</div>
											</header>
											<main><button>Add validation data</button></main>
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
					<button id="send">Update current service in portal</button>
					<button id="delete">Delete current service in portal</button>
				</section></>
			);
		}
		else{
			dr = (
				<><input type="hidden" id="ready-query" name="ready-query" value="" /><div id="add-category">
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
				</div></>
			);
		}
		
		return dr;
	}
}

const HeaderRender = (hash) => {
  let render = "";
  switch(hash){
    case "#add": render = '<a href="/admin?svc=adminUsers&subSVC=portalServices">Back to list</a>'; break;
    case "#edit": render = '<a href="/admin?svc=adminUsers&subSVC=portalServices">Back to list</a>'; break;
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


$('.data-page > header h2').html(document.title);

$(document).ready(function(){
	$(window).on('hashchange',function(){
		let s = window.location.hash;
		
		HeaderRender(s);
		UIRender(s);
		UXRender(s);
	}).trigger('hashchange');
	
});
