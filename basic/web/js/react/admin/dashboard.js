const tabSwitcher = () => {
  $('.admin-dashboard > header #board-tabs section').click(function(e,t){
    let allBlock = [
      $('.admin-dashboard > header #board-tabs section'),
      $('.admin-dashboard > main ul li')
    ],
        cur_allBlock = [
      $('.admin-dashboard > header #board-tabs section').eq($(this).index()),
      $('.admin-dashboard > main ul li').eq($(this).index())
    ];
    
    for(let i = 0; i < allBlock.length; i++){
      allBlock[i].removeClass('active');
      cur_allBlock[i].addClass('active');
    }
  });
}
$(document).ready(tabSwitcher);

class BasicTab extends React.Component{
  render(){
    return (
      <React.Fragment>
        <section id="dashboard-header">
          <div>
            <h2>Welcome to Admin Services!</h2>
          </div>
          <div>
            <span>Data Basic Services</span>
            <nav>
              <a href="/admin?svc=dataManagment&subSVC=attributes#list">All attributes</a>
            </nav>
          </div>
          <div>
            <span>Content Basic Services</span>
            <nav>
              <a href="/admin?svc=dataManagment&subSVC=news#add">Add news to portal</a>
              <a href="/admin?svc=dataManagment&subSVC=events#add">Add event to portal</a>
              <a href="/admin?svc=dataManagment&subSVC=analytics#add">Add article to content</a>
            </nav>
          </div>
        </section>
        <section id="dashboard-content">
        </section>
      </React.Fragment>
    );
  }
}
class DataTab extends React.Component{
  render(){
	return(
		<React.Fragment>
			<section id="dashboard-header">
			  <div>
				<h2>Portal Data Managment</h2>
			  </div>
			  <div>
				<span>Managment Basic Services</span>
				<nav>
				  <a href="/admin?svc=dataManagment&subSVC=portalServices">All portal services</a>
				  <a href="/admin?svc=portalUsers&subSVC=list">All portal users</a>
				</nav>
			  </div>
			  <div>
				<span>Managment Critical Services</span>
				<nav>
				  <a href="/admin?svc=dataManagment&subSVC=portalServices&page=managment&contentStatus=true#add">Add New Service Category</a>
				  <a href="/admin?svc=dataManagment&subSVC=portalServices&page=managment&contentStatus=false#add">All New Item to current Service Category</a>
				</nav>
			  </div>
			</section>
			<section id="dashboard-content">
			</section>
		</React.Fragment>
	);
  }
}
class ContentTab extends React.Component{
  render(){
    return(
		<React.Fragment>
			<section id="dashboard-header">
			  <div>
				<h2>Portal Content Managment</h2>
			  </div>
			  <div>
				<span>Managment Basic Services</span>
				<nav>
				  <a href="/admin?svc=dataManagment&subSVC=news#list">All news</a>
				  <a href="/admin?svc=dataManagment&subSVC=analytics#list">All analytics articles</a>
				  <a href="/admin?svc=dataManagment&subSVC=events#list">All events</a>
				</nav>
			  </div>
			  <div>
				<span>Managment Critical Services</span>
				<nav>
				  <a href="/admin?svc=dataManagment&subSVC=news#categories">All news categories</a>
				  <a href="/admin?svc=dataManagment&subSVC=analytics#categories">All analytics categories</a>
				</nav>
			  </div>
			</section>
			<section id="dashboard-content">
			</section>
		</React.Fragment>
	);
  }
}
let cmps = [
  <BasicTab />,<DataTab />,<ContentTab />
];

for(let i = 0; i < cmps.length; i++){
  const tabContent = document.querySelectorAll('.admin-dashboard > main ul li');
  ReactDOM.render(cmps[i], tabContent[i]);
}
