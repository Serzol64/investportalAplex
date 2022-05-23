let currentService = $('#service-page-form > div[data-serviceForm-type="main"]').data('service');


class RegionList extends React.Component{
	constructor(props){
		super(props);
		this.state = {
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
		const myStates = this.state.region.map((myState) =>
			<option value={myState.code}>{ myState.title }</option>
		);
		return (
			<React.Fragment>
			  {myStates}
			</React.Fragment>
		);
	}
}

class ServiceForm extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            formStep: {
                header: {},
                body: {},
                footer: {}
            }
        }
    }
    componentDidMount(){
        
    }
    render(){
        return (
            <React.Fragment>
                <header id="formUI">
                    <ul className="formStep">
                        { this.isVisitor(0) }
                        {
                            this.state.formStep.header.map((ft) => {
                                '<li id="step">' + this.formGenerator('header', ft.fieldGen) + '</li>'
                            })
                        }
                    </ul>
                </header>
                <main id="formUI">
                    <section className="formStep">
                        { this.isVisitor(2) }
                        {
                            this.state.formStep.body.map((fi) => {
                                '<div id="step">' + this.formGenerator('content', fi.fieldGen) + '</div>'
                            })
                        }
                    </section>
                </main>
                <footer id="formUI">
                <section className="formStep">
                        { this.isVisitor(1) }
                        {
                            this.state.formStep.footer.map((fBut) => {
                                '<div id="step">' + this.formGenerator('footer', fBut.fieldGen) + '</div>'
                            })
                        }
                    </section>
                </footer>
            </React.Fragment>
        );
    }
    formGenerator(block, newField){
        let formResponse = null;
        switch(block){
            case 'header': 
                formResponse = `Step ${newField.stepN}: ${newField.stepT}`;
            break;
            case 'content':
                let formContent = null;
                if(newField.type === 'upload'){
                    const ufld = newField.form.map((ufd) => {
                        <label>
                            <span>{ sfd.name }</span>
                            <input type="upload" id="upload-field" className={ ufd.fieldName } placeholer={ ufd.dExample } />
                        </label>
                    });

                    formContent = (
                        <>
                            <div id="header">{ newField.stepD }</div>
                            <div id="body">{ ufld }</div>
                        </>
                    );
                }
                else if(newField.type === 'default'){
                    const dfld = newField.form.map((dfd) => {
                        <label>
                            <span>{ sfd.name }</span>
                            <input type="text" id="default-field" className={ dfd.fieldName } placeholer={ dfd.dExample } />
                        </label>
                    });

                    formContent = (
                        <>
                            <div id="header">{ newField.stepD }</div>
                            <div id="body">{ dfld }</div>
                        </>
                    );
                }
                else if(newField.type === 'search'){
                    const sfld = newField.form.map((sfd) => {
                        <label>
                            <span>{ sfd.name }</span>
                            <input type="search" id="search-field" className={ sfd.fieldName } data-searchSource={ sfd.dSource } placeholer={ sfd.dExample } />
                        </label>
                    });

                    formContent = (
                        <>
                            <div id="header">{ newField.stepD }</div>
                            <div id="body">{ sfld }</div>
                        </>
                    );
                }
                else if(newField.type === 'list'){
                    const df = newField.optionData.map((ods) => {
                        <option value={ ods.lfQuery }>{ ods.lfContent }</option>
                    });

                    formContent = (
                        <>
                            <div id="header">{ newField.stepD }</div>
                            <div id="body">
                                <label>
                                    <span>{ newField.listTitle }</span>
                                    <select id="list-field" className={ newField.listName }>{ df }</select>
                                </label>
                            </div>
                        </>
                    );
                }

                formResponse = formContent;
            break;
            case 'footer':
               if(newField.isLast){
                    formResponse = (
                        <div id="body"><button>Countine</button></div>
                    );
               }
               else{
                    formResponse = (
                        <div id="body"><button>Send query to service</button></div>
                    );
               }
            break;
        }

        return formResponse;
    }
    isVisitor(q){
        let formVisibile = null;
        if(!get_cookie('portalId')){
            
            if(q === 2){
                formVisibile = (
                    <>
                    <div id="header">
                        <p>Since you are not authorized or registered on the portal, you need to enter some mandatory personal data, from which the portal service will accept your request in an average of half an hour after registering the requests you have sent. This will strengthen the level of processing and execution of requests in general, distributing the load most often over time!</p>
                    </div>
                    <div id="body">
                        <label>
                            <span>Firstname</span>
                            <input type="text" id="fn" placeholder="Jonh" />
                        </label>
                        <label>
                            <span>Surname</span>
                            <input type="text" id="sn" placeholder="Jonhson" />
                        </label>
                        <label>
                            <span>Country</span>
                            <select id="region">
                                <option value="any">Any country</option>
                                <RegionList />
                            </select>
                        </label>
                    </div>
                    <div id="footer">
                        <label>
                            <span>Your email</span> 
                            <input type="email" id="email" placeholder="jonh@gmail.com" />
                        </label>
                        <label>
                            <span>Your phone</span>
                            <input type="phone" id="phone" placeholder="79012345678" />
                        </label>
                    </div>
                    </>
                );
            }
            else if(q === 1){
                formVisibile = (
                    <>
                    <div id="header">
                        <input type="checkbox" name="dataAgree" value="ok" />
                        <span>I consent to the provision of temporary services for processing, transferring, searching and destroying the entered personal data in accordance with the Portal's Data Privacy Policy and regulatory documents regulating such processes in the country where I will provide the data to the Portal service</span>
                    </div>
                    <div id="body">
                        <button disabled>Countine</button>
                    </div>
                    </>
                );
            }
            else if(q === 0){
                formVisibile = (
                    <li id="step">Please, input your personal contact data!</li>
                );
            }
        }

        return formVisibile;
    }
}

ReactDOM.render(<ServiceForm />, document.getElementById('svcForm'));
