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
    
class Add extends React.Component{
	constructor(props){
		super(props);
		this.state = { currentType: params['contentStatus'] };
	}
	componentDidMount(){
		
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
				<section id="news-list">
				  <header data-block="name">
					<input type="text" id="title" placeholder="Input service name"/>
				  </header>
				  <main data-block="content">
				    <h3>Service meta data</h3>
				    <ul data-group="meta">
						<li>
							<!--SEO Data-->
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
							<!--Security-->
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
							<!--Text Data-->
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
							<!--Form Data-->
							<nav>
								<div className="wf">
									<h4>Adding form elements</h4>
									<div className="add-formElements">
									  <header>
										<div>
										</div>
									  </header>
									  <main><button>Add element</button></main>
									</div>
								</div>
							</nav>
						</li>
						<li>
							<!--Validator Data-->
							<nav>
								<div className="wf">
									<h4>Adding form validation errors</h4>
									<div className="add-validator">
									  <header>
										<div>
											<input type="text" name="field" id="field" placeholder="Enter the field name" />
											<select name="fieldType" id="fieldType">
												<option>Select form field type</option>
												<option value="default">Text form</option>
												<option value="list">List form</option>
												<option value="region">Regions list form</option>
												<option value="upload">File uploader</option>
												<option value="search">Search form</option>
											</select>
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
				  <button id="send">Send service to portal</button>
				</section>
			);
		}
		else{
			dr = (
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
				  <button>Insert category</button>
				</div>
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
				<section id="news-list">
				  <header data-block="name">
					<input type="text" id="title" placeholder="Input service name"/>
				  </header>
				  <main data-block="content">
				    <h3>Service meta data</h3>
				    <ul data-group="meta">
						<li>
							<!--SEO Data-->
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
							<!--Security-->
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
							<!--Text Data-->
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
							<!--Form Data-->
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
												<option value="region">Regions list form</option>
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
							<!--Validator Data-->
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
				  <button id="send">Send service to portal</button>
				</section>
			);
		}
		else{
			dr = (
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
				  <button>Insert category</button>
				</div>
			);
		}
		
		return dr;
	}
}

const HeaderRender = (hash) => {
  let render = "";
  switch(hash){
    case "#add": render = ''; break;
    case "#edit": render = ''; break;
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
