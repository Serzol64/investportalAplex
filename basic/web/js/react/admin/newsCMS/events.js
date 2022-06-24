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

class List extends React.Component{
	constructor(props){
		super(props);
		this.state = { newsList: [] };
	}
	getNewsLink(id){ return '/admin?svc=dataManagment&subSVC=events&id=' + id + '#edit'; }
	componentDidMount(){
		var lfd = new FormData();
		
		let listNewsQuery = { svc: 'list' };
		
		lfd.append('svcQuery', JSON.stringify(listNewsQuery));
		
		fetch('admin/api/dataServices/newsService/Events/show', { method: 'POST', body: lfd })
			.then((response) => { if(response.ok){ return response.json(); } })
			.then((data) => this.setState({ newsList: data }))
			.catch( error => { console.error( error ); } );
	}
	render(){
		
		return (
			<React.Fragment>
				<section id="news-list">
				  <header data-block="search">
					<input type="search" placeholder="Find matherials"/>
				  </header>
				  <main data-block="list">
				    { this.state.newsList ? 
					  this.state.newsList.map((myState) => (
						  <div id="news">
							  <header data-news={ myState.id }>{ myState.title }</header>
							  <a href={ this.getNewsLink(myState.id) }>Edit</a>
						  </div>
					  )) : 'Not events data'
					}
				  </main>
				</section>
			</React.Fragment>
		);
	}
}
class Add extends React.Component{
	componentDidMount(){
		CKEDITOR.replace('eventEditor', { stylesSet: 'eventEditorStyles' });
		
		$('button#send').click(function(e,t){
			let serviceQuery = {
				content: {
					svc: 'content',
					parameters: {
						operation: 'send',
						query: {
							title: $('input#title').val(),
							image: get_cookie('titleImage'),
							period: [$('.period > ul li #from').val(), $('.period > ul li #to').val()],
							content: this.generateEventData(CKEDITOR.instances.eventEditor.getData())
						}
					}
				},
				meta: {
					svc: 'titleImage',
					parameters: {
						operation: 'send',
						isTitlePhoto: true,
						photoData: {
							isSVC: {
								send: true,
								update: false
							},
							ext: sessionStorage.getItem('ext'),
							data: $('#uploaded').attr('src')
						}
						
					}
				}
			};
			
			titleImageSend(serviceQuery.meta);
			sendEvent(serviceQuery.content);
		});
                     
        $('#titleImageU').change(function(e){
			const file = e.target.files[0];

			const reader = new FileReader();
			reader.onloadend = () => {
				$('#uploaded').attr('src', reader.result);
			};
			reader.readAsDataURL(file);
			sessionStorage.setItem('ext', getExtension(file));
		});
	}
	render(){
		return (
			<React.Fragment>
				<section id="events-list">
				  <header data-block="name">
					<input type="text" placeholder="Input event title..."/>
				  </header>
				  <section data-block="titleImage">
					<div className="period">
						<span>Expire of the event:</span>
						<ul>
							<li><input type="datetime-local" id="from" /></li>
							<li><input type="datetime-local" id="to" /></li>
						</ul>
					</div>
				    <label htmlFor="titleImageU"><input type="file" name="titleImageU" id="titleImageU" accept="image/*" />Upload title image</label>
					<img src="https://storage.yandexcloud.net/printio/assets/realistic_views/canvas30x30/detailed/74c7d27d11c90643e74e99cf7e8c85a4f8d0dd88.png?1534453806" id="uploaded" />
				  </section>
				  <main data-block="form">
					<div id="news"><textarea id="eventEditor" name="eventEditor"></textarea></div>
				  </main>
				  <button id="send">Add event page</button>
				</section>
			</React.Fragment>
		);
	}
	generateEventData(content){
		let contentParse = DOMParse.parseFromString(content, 'text/html'),
			readyQuery = {
				program: {
					primeTime: {},
					primeTimeMeta: {}
				},
				organizatorWebSite: ''
			};
		
		var programTable = contentParse.getElementById('program'),
			primeTimeAll = contentParse.querySelectorAll('#primetime li');
			
		let sessionDate = [],
			sessionTime = [],
			sessionTitle = [];
			
		for(let i = 0; i < programTable.rows.length; i++){
			
			if(i === 0){
				let eventDates = programTable.rows.item(i).cells;
				
				for(let j = 0; i < eventDates.length; i++){ sessionDate.append(eventDates.item(i).innerHTML); }
			}
			else if(i === 1){
				let eventTimes = programTable.rows.item(i).cells;
				
				for(let j = 0; i < eventTimes.length; i++){ sessionTime.append(eventTimes.item(i).innerHTML); }
			}
			else if(i === 2){
				let eventTitles = programTable.rows.item(i).cells;
				
				for(let j = 0; i < eventTitles.length; i++){ sessionTitle.append(eventTitles.item(i).innerHTML); }
			}
		}
		
		for(let i = 0; i < primeTimeAll.length; i++){
			let metaData = {
				id: i,
				date: sessionDate[i],
				time: sessionTime[i],
				content: primeTimeAll[i].innerText
			};
			
			readyQuery.primeTimeMeta.append(metaData);
		}
		
		for(let i = 0; i < sessionTitle.length; i++){
			readyQuery.primeTime.append({
				id: i,
				date: sessionDate[i],
				time: sessionTime[i],
				title: sessionTitle[i]
			});
		}
		
		readyQuery.organizatorWebSite = content.getElementById('organizatorContact').getAttribute('href');
		
		return JSON.stringify(readyQuery);
	}
}
class Edit extends React.Component{
	constructor(props){
		super(props);
		this.state = { 
			currentEvent: [] 
		};
	}
	componentDidMount(){
		
		let eq = {
			svc: 'content',
			parameters: {
				operation: 'show',
				query: { id: params['id'] }
			}
		};
		
		var fdes = new FormData();
		fdes.append('svcQuery', JSON.stringify(eq));
		
		fetch('/admin/api/dataServices/newsService/Events/show',{ method: 'POST', body: fdes })
			.then((response) => {
				if(response.status === 200){ return response.json(); }
				else{ window.location.assign('/admin?svc=dataManagment&subSVC=events#list'); }
			})
			.then(data => this.setState({ currentEvent: data[0] }));
			
		CKEDITOR.replace('eventEditor', { stylesSet: 'eventEditorStyles' });
        
		$('button#send').click(function(e,t){
			let updateQuery = {
				content: {
					svc: 'content',
					parameters: {
						operation: 'update',
						query: {
							id: params['id'],
							title: $('input#title').val() || get_cookie('title'),
							image: get_cookie('titleImage_update'),
							period: [$('.period > ul li #from').val(), $('.period > ul li #to').val()],
							content: this.generateEventData(CKEDITOR.instances.eventEditor.getData())
						}
					}
				},
				meta: {
					svc: 'titleImage',
					parameters: {
						operation: 'update',
						isTitlePhoto: true,
						photoData: {
							isSVC: {
								send: false,
								update: true
							},
							ext: sessionStorage.getItem('ext'),
							data: $('#uploaded').attr('src')
						}
						
					}
				}
			};
			
			updateEvent(updateQuery);
		});
		$('button#delete').click(function(e,t){
			let deleteQuery = {
				content: {
					svc: 'content',
					parameters: {
						operation: 'delete',
						query: {
							id: params['id']
						}
					}
				},
				meta: {
					svc: 'titleImage',
					parameters: {
						operation: 'delete',
						data: this.getCurrentImage(params['id'])
					}
				}
			};
			
			deleteEvent(deleteQuery);
		});
		
		
		$('#titleImageU').change(function(e){
			const file = e.target.files[0];

			const reader = new FileReader();
			reader.onloadend = () => {
				$('#uploaded').attr('src', reader.result);
			};
			reader.readAsDataURL(file);
			sessionStorage.setItem('ext', getExtension(file));
		});
		
		window.setTimeout(function(){ CKEDITOR.instances.eventEditor.setData($('#events-list > #contentData').val()) }, 3000); 
	}
	render(){
		set_cookie('titleEvent', this.state.currentEvent.title, strtotime('+ 1 minute', Date.now()), '/');
		set_cookie('titleImageEvent_update', this.state.currentEvent.titleImage, strtotime('+ 2 minutes', Date.now()), '/');
		
		return (
			<React.Fragment>
				<section id="events-list">
				  <input type="hidden" name="contentData" id="contentData" value={ this.dataReverse(this.state.currentEvent.content) } />
				  <header data-block="name">
					<input type="text" placeholder="Update event title..." value={ this.state.currentEvent.title }/>
				  </header>
				  <section data-block="titleImage">
				    <label htmlFor="titleImageU"><input type="file" name="titleImageU" id="titleImageU" accept="image/*" />Upload title image</label>
					<img src={ this.state.currentEvent.titleImage } id="uploaded" />
				  </section>
				  <main data-block="form">
					<div id="news"><textarea id="eventEditor" name="eventEditor"></textarea></div>
				  </main>
				  <button id="send">Update news</button>
				  <button id="delete" style={{ backgroundColor: 'red' }}>Delete news</button>
				</section>
			</React.Fragment>
		);
	}
	generateEventData(content){
		let contentParse = DOMParse.parseFromString(content, 'text/html'),
			readyQuery = {
				program: {
					primeTime: {},
					primeTimeMeta: {}
				},
				organizatorWebSite: ''
			};
		
		var programTable = contentParse.getElementById('program'),
			primeTimeAll = contentParse.querySelectorAll('#primetime li');
			
		let sessionDate = [],
			sessionTime = [],
			sessionTitle = [];
			
		for(let i = 0; i < programTable.rows.length; i++){
			
			if(i === 0){
				let eventDates = programTable.rows.item(i).cells;
				
				for(let j = 0; i < eventDates.length; i++){ sessionDate.append(eventDates.item(i).innerHTML); }
			}
			else if(i === 1){
				let eventTimes = programTable.rows.item(i).cells;
				
				for(let j = 0; i < eventTimes.length; i++){ sessionTime.append(eventTimes.item(i).innerHTML); }
			}
			else if(i === 2){
				let eventTitles = programTable.rows.item(i).cells;
				
				for(let j = 0; i < eventTitles.length; i++){ sessionTitle.append(eventTitles.item(i).innerHTML); }
			}
		}
		
		for(let i = 0; i < primeTimeAll.length; i++){
			let metaData = {
				id: i,
				date: sessionDate[i],
				time: sessionTime[i],
				content: primeTimeAll[i].innerText
			};
			
			readyQuery.primeTimeMeta.append(metaData);
		}
		
		for(let i = 0; i < sessionTitle.length; i++){
			readyQuery.primeTime.append({
				id: i,
				date: sessionDate[i],
				time: sessionTime[i],
				title: sessionTitle[i]
			});
		}
		
		readyQuery.organizatorWebSite = content.getElementById('organizatorContact').getAttribute('href');
		
		return JSON.stringify(readyQuery);
	}
	dataReverse(content){
		let generatingResponse = null;
		var contentEditor = [new HTMLBuilder(), new HTMLBuilder(), new HTMLBuilder()];
		
		
		
		return generatingResponse;
	}
}

function sendEvent(q){
		var querySendData = new FormData();
		
		querySendData.append('svcQuery', JSON.stringify(q));
		
		fetch('admin/api/dataServices/newsService/Events/send', { method: 'POST', body: querySendData })
		.then((response) => {
			if(response.status === 200){ 
				console.log('Content success upload!'); 
				window.location.assign('/admin?svc=dataManagment&subSVC=events#list');
			}
			else{ alert('Content failed upload!'); }
		})
		.catch(error => {
			alert('Response error!');
			console.log(error);
		});
}
function titleImageSend(q){
		var querySendMedia = new FormData();
		
		querySendMedia.append('svcQuery', JSON.stringify(q));
		
		fetch('admin/api/dataServices/newsService/Events/send', { method: 'POST', body: querySendMedia })
		.then((response) => {
			if(response.status === 200){ console.log('Title image success upload!'); }
			else{ alert('Title image failed upload!'); }
		})
		.catch(error => {
			alert('Response error!');
			console.log(error);
		});
		
}

function updateEvent(q){
		var fdu = [new FormData(), new FormData()];
		
		fdu[0].append('svcQuery', JSON.stringify(q.meta));
		fdu[1].append('svcQuery', JSON.stringify(q.content));
		
		fetch('admin/api/dataServices/newsService/Events/update', { method: 'POST', body: fdu[0] })
		.then((response) => {
			if(response.status === 200){ console.log('Title image success update!'); }
			else{ alert('Title image failed update!'); }
		})
		.catch(error => {
			alert('Response error!');
			console.log(error);
		});
		
		fetch('admin/api/dataServices/newsService/Events/update', { method: 'POST', body: fdu[1] })
		.then((response) => {
			if(response.status === 200){ 
				console.log('Content success update!'); 
				window.location.assign('/admin?svc=dataManagment&subSVC=events#list');
			}
			else{ alert('Content failed update!'); }
		})
		.catch(error => {
			alert('Response error!');
			console.log(error);
		});
}
function deleteEvent(q){
		var fdd = [new FormData(), new FormData()];
		
		fdd[0].append('svcQuery', JSON.stringify(q.meta));
		fdd[1].append('svcQuery', JSON.stringify(q.content));
		
		fetch('admin/api/dataServices/newsService/Events/delete', { method: 'POST', body: fdd[1] })
		.then((response) => {
			if(response.status === 200){ console.log('Content success delete!'); }
			else{ alert('Content failed delete!'); }
		})
		.catch(error => {
			alert('Response error!');
			console.log(error);
		});
		
		fetch('admin/api/dataServices/newsService/Events/delete', { method: 'POST', body: fdd[0] })
		.then((response) => {
			if(response.status === 200){ 
				console.log('Title image success delete!'); 
				window.location.assign('/admin?svc=dataManagment&subSVC=events#list');
			}
			else{ alert('Title image failed delete!'); }
		})
		.catch(error => {
			alert('Response error!');
			console.log(error);
		});
}

const HeaderRender = (hash) => {
  let render = '';
  switch(hash){
    case "#add": render = '<a href="/admin?svc=dataManagment&subSVC=events#list">Back to list</a>'; break;
	case "#edit": render = '<a href="/admin?svc=dataManagment&subSVC=events#list">Back to list</a>'; break;
	default: render = '<a href="#add">New matherial</a>'; break;
  }
  
   $('.data-page > header nav').html(render);
}
document.title = "Events";
const UIRender = (hash) => {
  switch(hash){
    case "#add": document.title = "Add new matherial"; break;
    case "#edit": document.title = "Edit current matherial"; break;
    default: document.title = "Events"; break;
  }
}
const UXRender = (hash) => {
  switch(hash){
    case "#add": ReactDOM.render(<Add />, document.querySelector('.data-page > main')); break;
    case "#edit": ReactDOM.render(<Edit />, document.querySelector('.data-page > main')); break;
    default: ReactDOM.render(<List />, document.querySelector('.data-page > main')); break;
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
