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
	}
	render(){
		return (
			<React.Fragment>
				<ul>
				  <li><a href="">Buy, sell and rent commercial real estate</a></li>
				</ul>
			</React.Fragment>
		);
	}
}

class List extends React.Component{
	constructor(props){
		super(props);
		this.state = { list: [], cQuery: [] };
	}
	componentDidMount(){
	}
	render(){
		return (
			<React.Fragment>
				<div id="services-list">
				  <header id="search">
					  <div class="categories">
						<a data-cat="" class="active-category">
						  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABmJLR0QA/wD/AP+gvaeTAAAC00lEQVRYhe2WO0wUURSGvzPDjqAmgDHEB43CxgeoibtWYCHWlhqxEKMJi6FCjBBD7AzRWuMOxldh1FjaGWJiFBsgBhRfC4UhROMLCoW4sPdY7C7PXXd2XbTxb2bm3nPP/fPff8658B//GJJuIhiOaA753qhM1/WHtn/wusDKYZPfYauo71HAfbXe64KMCvQ1+dPGpIpPwLMS+VYA4CVxJR7uvDJc9tcJxBzqgBdAtSP6ONNx5J3A8+P+zzGH/QkSGT1RkG8CwXBEiS4Y2irqewjsSBW/HB5Ihep0E3lTIN3fkqme/C0F8kcgGI5ojlUyJTwfQcDt81mmuDO5c9AdvqBMdPSHgtPJmKrLQ6tXWivqET1sYIvAulnibqR5aiZ6a6i56vv8vJ4VEC05r0Lr7IDqGcsUdyY/d18eriyynUEV7VKoE9gI2HPxXCqynYGAG6nIiQCqx+JPqRVLauKvnJhNZOtVYJPCACr1PjXlE1EKfWrKQY8oDACbLaVrflrvf4HE+4bYaG9j5TOW9pEaACsmB3qbK0eTg8MwBtwJuCM9qHmvUJsTAYFrCm1qtGdPODKuws2p0mj70KGqZNnxARhbHwTcdxetGevJeEw/ldpSZgrMXiHWluDs5ERgck30XOE3x4jSoMIGlJaicQfg1CKiu1C5rbZSYoOiiKZvqJ49MHSoKtrf5D/bd9K/MekBlIbFcSISQqVb49L/VBhDpVtEQqnyelYgGI6MAyViSQ3GFCTkXFIPDHKv/2RF1+LxgDtSLKibMwGEGygtarRnzn9yfUmcmscZPJAbganSaPvKr45J1gKBC6s+jnYs5ZmdBzwTSLj9dDAcaQXobfK3p4oTkZAaDqroNoG1Cl9E5bVY3Ff9kyNI4Dd3xGnA58EDC24L+byQPAX2ZfaAPsmKQLadL4MHRsTQmBWBP0QM+AD6VkXuThdN3hk8uuvHMu/5H9nhF5JAPQ7UqmmhAAAAAElFTkSuQmCC" />
						  <strong>Investment and Objects</strong>
						</a>
					  </div>
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
