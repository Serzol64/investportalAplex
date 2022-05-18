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
    
    
class Services extends React.Component{
	constructor(props){
		super(props);
		
		this.query = props.q;
		this.state = { list: [] };
	}
	componentDidMount(){
		fetch('/admin/api/dataServices/filters/portalServicesCategory/show', { method: 'GET'})
			.then(response => response.json())
			.then(this.generateSmartResponse)
			.catch(error => {
				alert('Response error!');
				console.log(error);
			});
	}
	generateSmartResponse(data){
		let sr = [];

		data.forEach((el) => {
			let metaData = JSON.parse(el.meta),
				query = this.query;

			if(metaData.seoData.categoryId === query){ sr.push({ id: el.id, title: el.title}); }
		});

		this.setState({ list: sr });
	}
	linkGenerator(q){ return '/admin?svc=adminUsers&subSVC=portalServices&contentStatus=true&id=' + q + '#edit'; }
	render(){
		const renderList = this.state.list.map((query) => {
			(
				<li><a href={ this.linkGenearator(query.id) }>{ query.title }</a></li>
			)
		});
		return (
			<React.Fragment>
				<ul>
				  { renderList }
				</ul>
			</React.Fragment>
		);
	}
}

class List extends React.Component{
	constructor(props){
		super(props);
		this.state = { list: [], cQuery: { catId: 1 } };
	}
	componentDidMount(){
		fetch('/admin/api/dataServices/filters/portalServices/send', { method: 'GET'})
			.then(response => response.json())
			.then(data => this.setState({ list: data }))
			.catch(error => {
				alert('Response error!');
				console.log(error);
			});

		
		$('#services-list > #list .categories a').click(function (e,t) { 
			e.preventDefault();
			
			let currentCat = $('#services-list > #list .categories a').eq($(this).index()).data('cat');
			this.setState({ cQuery: { catId: currentCat } });
		});

		$('#services-list > #list .categories a').eq(0).addClass('active-category');
	}
	blobToImage(q){
		const reader = new FileReader();
		reader.onloadend = () => { return reader.result; };
		reader.readAsText(q);
	}
	render(){

		const catsList = this.state.list.map((query) => {
			(
				<a data-cat={ query.id }>
					<img src={ this.blobToImage(query.icon) } />
					<strong>{ query.title }</strong>
				</a>
			)
		});
		return (
			<React.Fragment>
				<div id="services-list">
				  <header id="search">
					  <div class="categories">{ catsList }</div>
				  </header>
				  <main id="list"><Services q={ this.state.cQuery } /></main>
				</div>
			</React.Fragment>
		);
	}
}

const HeaderRender = () => {
  let render = '<a href="/admin?svc=adminUsers&subSVC=portalServices&page=managment&contentStatus=false#add">Add services category</a>';
  render += '<a href="/admin?svc=adminUsers&subSVC=portalServices&page=managment&contentStatus=true#add">Add new service</a>';
  
  $('.data-page > header nav').html(render);
}
const UXRender = () => { ReactDOM.render(<List />, document.getElementById('cms-service')); }

$(document).ready(function(){
	HeaderRender();
	UXRender();
});
