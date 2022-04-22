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
	render(){
		return (
			<React.Fragment>
				<section id="analytics-list">
				  <header data-block="search">
					<input type="search" placeholder="Find matherials"/>
				  </header>
				  <main data-block="list">
					<div id="news">
					  <header data-news="">Analytic example</header>
					  <main>01-01-2022 10:00:00</main>
					  <footer>Edit</footer>
					</div>
					<div id="news">
					  <header data-news="">Analytic example</header>
					  <main>01-01-2022 10:00:00</main>
					  <footer>Edit</footer>
					</div>
					<div id="news">
					  <header data-news="">Analytic example</header>
					  <main>01-01-2022 10:00:00</main>
					  <footer>Edit</footer>
					</div>
					<div id="news">
					  <header data-news="">Analytic example</header>
					  <main>01-01-2022 10:00:00</main>
					  <footer>Edit</footer>
					</div>
				  </main>
				</section>
			</React.Fragment>
		);
	}
}
class Add extends React.Component{
	componentDidMount(){
		ClassicEditor.create( document.querySelector( '#analyticEditor' ), this.dataParam() )
                     .catch( error => { console.error( error ); } );
	}
	render(){
		return (
			<React.Fragment>
				<section id="analytics-list">
				  <header data-block="name">
					<input type="text" placeholder="Input matherial title..."/>
				  </header>
				  <main data-block="form">
					<div id="news"><textarea id="analyticEditor"></textarea></div>
				  </main>
				</section>
			</React.Fragment>
		);
	}
	dataParam(){
		return {
			placeholder: 'Adding analytic matherial content...',
			heading: {
				options: [
					{model: 'paragraph', title: 'Analytic paragraph'},
					{model: 'paragraph', title: 'Analytic bookmark', class: 'bookmark'},
					{model: 'paragraph', title: 'Analytic sub bookmark', class: 'subBookmark'}
				]
			}
		};
	}
}
class Edit extends React.Component{
	componentDidMount(){
		ClassicEditor.create( document.querySelector( '#analyticEditor' ), this.dataParam() )
                     .catch( error => { console.error( error ); } );
	}
	render(){
		return (
			<React.Fragment>
				<section id="event-list">
				  <header data-block="name">
					<input type="text" placeholder="Update matherial title..." value="Test UI example..."/>
				  </header>
				  <main data-block="form">
					<div id="news"><textarea id="analyticEditor"></textarea></div>
				  </main>
				</section>
			</React.Fragment>
		);
	}
	dataParam(){
		return {
			placeholder: 'Update analytic matherial content...',
			heading: {
				options: [
					{model: 'paragraph', title: 'Analytic paragraph'},
					{model: 'paragraph', title: 'Analytic bookmark', class: 'bookmark'},
					{model: 'paragraph', title: 'Analytic sub bookmark', class: 'subBookmark'}
				]
			}
		};
	}
}

const HeaderRender = (hash) => {
  let render = '';
  switch(hash){
    case "#add": render = '<a href="/admin?svc=dataManagment&subSVC=news#list">Back to list</a>'; break;
	case "#edit": render = '<a href="/admin?svc=dataManagment&subSVC=news#list">Back to list</a>'; break;
	default: render = '<a href="#add">New matherial</a>'; break;
  }
  
   $('.data-page > header nav').html(render);
}
document.title = "Analytics";
const UIRender = (hash) => {
  switch(hash){
    case "#add": document.title = "Add new matherial"; break;
    case "#edit": document.title = "Edit current matherial"; break;
    default: document.title = "Analytics"; break;
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
