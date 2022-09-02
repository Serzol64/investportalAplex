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
		this.state = { query: props.q, list: [] };
	}
	componentDidMount(){
		var fda = new FormData();
		fda.append('categoryId', this.state.query);
		fetch('/admin/api/dataServices/filters/portalServicesCurrentCategory/show', { method: 'POST', body: fda })
			.then(response => response.json())
			.then((data) => {
				this.setState({ list: data });
			});
	}
	render(){
		
		const renderList = this.state.list.map(query => <li><a href={ '/admin?svc=dataManagment&subSVC=portalServices&page=managment&contentStatus=true&id=' + query.id + '#edit' }>{ query.title }</a></li>);
		return (
			<React.Fragment><ul>{ renderList }</ul></React.Fragment>
		);
	}
}

class List extends React.Component{
	constructor(props){
		super(props);
		this.state = { list: [], cQuery: 0 };
	}
	componentDidMount(){
		fetch('/admin/api/dataServices/filters/portalServicesCategory/show', { method: 'GET'})
			.then(response => response.json())
			.then(data => this.setState({ list: data }))
			.catch(error => {
				alert('Response error!');
				console.log(error);
			});
			
		$('.categories > a').click((e,t) => {
			e.preventDefault();
			
			$(".categories > a").removeClass('active-category');
			$(".categories > a").eq($(this).index()).addClass('active-category');
				
			let currentCat = $('.categories > a').eq($(this).index()).data('cat');
			this.setState({ cQuery: currentCat });
			
			$('.load-screen-services').removeClass('list-smart-close');
			$('.not-found-data, main#list > ul').addClass('list-smart-close');
		});
	}
	render(){

		const catsList = this.state.list.map((query, index) => {
			
			if(index > 0){
				return (
					<a data-cat={ query.id } href="#">
						<ImageWorkTag srcQuery={ query.icon } />
						<strong>{ query.name }</strong>
					</a>
				);
			}
			else{
				return (
					<a data-cat={ query.id } href="#" className="active-category">
						<ImageWorkTag srcQuery={ query.icon } />
						<strong>{ query.name }</strong>
					</a>
				);
			}
		});
		
		
		return (
			<React.Fragment>
				<div id="services-list">
				  <header id="search">
					  <div className="categories">{ catsList }</div>
				  </header>
				  <main id="list"><Services q={ this.state.cQuery === 0 ? 1 : this.state.cQuery } /></main>
				</div>
			</React.Fragment>
		);
	}
}

const ImageWorkTag = (props) => { return <img src={ props.srcQuery } /> }

const HeaderRender = () => {
  let render = '<a href="/admin?svc=dataManagment&subSVC=portalServices&page=managment&contentStatus=false#add" style="position:relative; left: -4%;">Add services category</a>';
  render += '<a href="/admin?svc=dataManagment&subSVC=portalServices&page=managment&contentStatus=true#add">Add new service</a>';
  
  $('.data-page > header nav').html(render);
}
const UXRender = () => { ReactDOM.render(<List />, document.querySelector('.data-page > main')); }

$(document).ready(function(){
	if(!params['page']){
		HeaderRender();
		UXRender();
	}
});
