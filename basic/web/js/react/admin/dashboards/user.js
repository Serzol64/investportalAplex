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
        <section className="user-page" data-type="basic">
		  <header id="user-page">
			<h2>Key indicators { 'for' } users of portal services</h2>
			<span id="development">There will be analytical data here. This block is under development!</span>
		  </header>
		  <main id="user-page">
			<h3>Figures and forecasts</h3>
			<span id="development">There will be analytical data here. This block is under development!</span>
		  </main>
		  <footer id="user-page">
			<h3>Basic services</h3>
			<div>
			  <div><a href="/admin?svc=portalUsers&subSVC=add">Add a user</a></div>
			  <div><a href="/admin?svc=portalUsers&subSVC=list">Portal users list</a></div>
			</div>
		  </footer>
		</section>
      </React.Fragment>
    );
  }
}
class DataTab extends React.Component{
  render(){
	return(
		<React.Fragment>
			<section className="user-page" data-type="data">
			  <header id="user-page">
				<h2>Portal Services Users Data</h2>
				<span id="development">There will be analytical data here. This block is under development!</span>
			  </header>
			  <main id="user-page">
				<h3>Data figures and forecasts</h3>
				<span id="development">There will be analytical and list data here. This block is under development!</span>
			  </main>
			</section>
		</React.Fragment>
	);
  }
}
class ContentTab extends React.Component{
  render(){
    return(
		<React.Fragment>
			<section className="user-page" data-type="content">
			  <header id="user-page">
				<h2>Portal Services Users Content</h2>
				<span id="development">There will be analytical data here. This block is under development!</span>
			  </header>
			  <main id="user-page">
				<h3>Content figures and forecasts</h3>
				<span id="development">There will be analytical and list data here. This block is under development!</span>
			  </main>
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
