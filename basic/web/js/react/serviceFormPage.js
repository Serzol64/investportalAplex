let currentService = $('#service-page-form > div[data-serviceForm-type="main"]').data('service');
let currentStep = 0, n;

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
        let currentServiceForm = {
            type: 'control',
            parameters: {
                service: 'getForm'
            }
        };
        var psfr = new FormData();
		
        psfr.append('cmd', JSON.stringify(currentServiceForm));
        fetch('/services/2/get?id=' + currentService, { method: 'GET', body: psfr})
            .then(response => response.json())
            .then((data) => {
                this.setState({
                    header: data.steps.header,
                    body: data.steps.content,
                    footer: data.steps.countines
                });
            })
            .catch((error) => {

            });

        $('#default-field').input(function(e,t){
            let curClass = this.className,
                curValue = this.value;

            var vsq = new FormData();

            let validQuery = {
                type: 'control',
                parameters: {
					service: 'validator',
                    fieldFormName: curClass,
                    fieldFormQuery: curValue
                }
            };

            alertify.set('notifier','position', 'top-right');
			alertify.set('notifier','delay', 5);

            vsq.append('cmd', JSON.stringify(validQuery));

            fetch('/services/2/get?id=' + currentService, { method: 'GET', body: vsq})
            .then(response => response.json())
            .then((data) => {
                switch(data.valid.classificator){
                    case true: return false; break;
                    default: alertify.error(data.valid.error); break;
                }
            });
        });
        $('#search-field').autocomplete({
            noCache: true,
            minChars: 2,
            maxHeight: $(window).height() / 6,
            lookup: this.findSearchData,
            onSelect: this.searchQueryGenerator
        });
        $('#list-field').change(function(e,t){
            $(this).css('border', 'solid 2px #0079bf');
        });
        $('#upload-field').change(function(e,t){
            let fileQuery = {},
                uploadedFiles = e.target.files,
                readersUpload = new FileReader();

            if($(this).length > 1){
                if(sessionStorage.getItem('uploaders')){
                    let existingData = JSON.parse(sessionStorage.getItem('uploaders'));

                    if(existingData.length === 1 || existingData.length > 1){
                        fileQuery.push(existingData);
                        fileQuery.push({});
                        for(var i = 0; i < uploadedFiles.length; i++){ fileQuery[(existingData.length - 1) + 1].push(readersUpload.result); }
                    }
                    else{
                        fileQuery.push(existingData);
                        fileQuery.push({});
                        for(var i = 0; i < uploadedFiles.length; i++){ fileQuery[$(this).index()%$(this).length].push(readersUpload.result); }
                    }

                    sessionStorage.removeItem('uploaders');
                }
                else{
                    fileQuery.push({});
                    for(var i = 0; i < uploadedFiles.length; i++){ fileQuery[$(this).index()%$(this).length].push(readersUpload.result); }
                }
            }
            else{
                readersUpload.onloadend = () => {
                    for(var i = 0; i < uploadedFiles.length; i++){ fileQuery.push(readersUpload.result); }
                };
            }

            readersUpload.readAsDataURL(uploadedFiles);
            sessionStorage.setItem('uploaders', JSON.stringify(fileQuery));

            $('main#formUI > .formStep #step #upload-field-content span').eq($(this).index()).text('You uploaded of files: ' + uploadedFiles.length);
        });
        $('footer#formUI > #body button').click(function(e,t){
            var message = $(this).text(),
                validCMD = new FormData();
            let formError = [],
                formValidQuery = {},
                errorContentForm = '';

            if(message.indexOf('Count')){
                var sllib = $('#formUI > .formStep #step');
                    n = currentStep + 1;

                let validField = [
                    $('main#formUI > .formStep #step').eq(currentStep).find('#default-field'),
                    $('main#formUI > .formStep #step').eq(currentStep).find('#search-field'),
                    $('main#formUI > .formStep #step').eq(currentStep).find('#list-field'),
                    $('main#formUI > .formStep #step').eq(currentStep).find('#upload-field')
                 ];

                 if(validField[1]){
                    formValidQuery = {
                        type: 'control',
                        parameters: {
							service: 'validator',
                            multiValidator: {
                                fieldsName: getArrayClasses(validField[1]),
                                fieldsValue: getArrayValues(validField[1])
                            }
                        }
                    };
                 }
                 else if(validField[0]){
                    formValidQuery = {
                        type: 'control',
                        parameters: {
							service: 'validator',
                            multiValidator: {
                                fieldsName: getArrayClasses(validField[0]),
                                fieldsValue: getArrayValues(validField[0])
                            }
                        }
                    };
                 }
                 else if(validField[2]){
                    formValidQuery = {
                        type: 'control',
                        parameters: {
							service: 'validator',
                            multiValidator: {
                                fieldsName: getArrayClasses(validField[2]),
                                fieldsValue: getArrayValues(validField[2])
                            }
                        }
                    };
                 }
                 else if(validField[3]){
                    formValidQuery = {
                        type: 'control',
                        parameters: {
							service: 'validator',
                            multiValidator: {
                                fieldsName: getArrayClasses(validField[3]),
                                fieldsValue: getArrayValues(validField[3])
                            }
                        }
                    };
                 }

                 validCMD.append('cmd', JSON.stringify(formValidQuery));

                 fetch('/services/2/post?id=' + currentService, {method: 'POST', body: validCMD})
                 .then(response => response.json())
                 .then((data) => {
                    if(data.error.length > 0){
                        for(var i = 0; i < data.error.length; i++){ formError.push(data.error[i]); }
                    }
                 });

                if(formError.length === 0){
                    sllib.eq(currentStep).css('display','none');
                    currentStep = (n+sllib.length)%sllib.length;
                    sllib.eq(currentStep).css('display','inthernit');
                }
                else{
                    alertify.set('notifier','position', 'bottom-right');
			        alertify.set('notifier','delay', 10);

                    for(var i = 0; i < formError.length; i++){ errorContentForm += formError[i] + '\n\n'; }

                    alertify.error(errorContentForm);
                }
            }
            else{
               var cmd = new FormData();
               let cmdQuery = null, fi, fields = $('main#formUI > .formStep div#step'), textFields, searchFields, listFields, uploadFields;
               
               let validFinal = [
                  $('main#formUI > .formStep #step').eq($('main#formUI > .formStep #step').length - 1).find('#default-field'),
                  $('main#formUI > .formStep #step').eq($('main#formUI > .formStep #step').length - 1).find('#search-field'),
                  $('main#formUI > .formStep #step').eq($('main#formUI > .formStep #step').length - 1).find('#list-field'),
                  $('main#formUI > .formStep #step').eq($('main#formUI > .formStep #step').length - 1).find('#upload-field')
               ];

               if(validFinal[1]){
                    formValidQuery = {
                        type: 'control',
                        parameters: {
							service: 'validator',
                            multiValidator: {
                                fieldsName: getArrayClasses(validFinal[1]),
                                fieldsValue: getArrayValues(validFinal[1])
                            }
                        }
                    };
               }
               else if(validFinal[0]){
                    formValidQuery = {
                        type: 'control',
                        parameters: {
							service: 'validator',
                            multiValidator: {
                                fieldsName: getArrayClasses(validFinal[0]),
                                fieldsValue: getArrayValues(validFinal[0])
                            }
                        }
                    };
               }
               else if(validFinal[2]){
                    formValidQuery = {
                        type: 'control',
                        parameters: {
							service: 'validator',
                            multiValidator: {
                                fieldsName: getArrayClasses(validFinal[2]),
                                fieldsValue: getArrayValues(validFinal[2])
                            }
                        }
                    };
               }
               else if(validFinal[3]){
                    formValidQuery = {
                        type: 'control',
                        parameters: {
							service: 'validator',
                            multiValidator: {
                                fieldsName: getArrayClasses(validFinal[3]),
                                fieldsValue: getArrayValues(validFinal[3])
                            }
                        }
                    };
               }

               validCMD.append('cmd', JSON.stringify(formValidQuery));

                fetch('/services/2/post?id=' + currentService, {method: 'POST', body: validCMD})
                 .then(response => response.json())
                 .then((data) => {
                    if(data.error.length > 0){
                        for(var i = 0; i < data.error.length; i++){ formError.push(data.error[i]); }
                    }
                 });
               
               if(formError.length === 0 && get_cookie('portalId')){
                   let authorizedQ = {
                    type: 'send',
                    parameters: {
                        portalId: get_cookie('portalId'),
                        text: [],
                        search: [],
                        list: [],
                        upload: []
                    }
                   };

                   for(fi = 0; fi < fields.length; fi++){
                        textFields = fields.eq(fi).find('#default-field');
                        searchFields = fields.eq(fi).find('#search-field');
                        listFields = fields.eq(fi).find('#list-field');
                        uploadFields = JSON.parse(sessionStorage.getItem('uploaders'));

                        let aqi;

                        if(textFields){
                            for(aqi = 0; aqi < textFields.length; aqi++){ authorizedQ.parameters.text.push(textFields.eq(aqi).val()); }
                        }
                        else if(searchFields){
                            for(aqi = 0; aqi < searchFields.length; aqi++){ authorizedQ.parameters.search.push(searchFields.eq(aqi).val()); }
                        }
                        else if(listFields){
                            for(aqi = 0; aqi < listFields.length; aqi++){ authorizedQ.parameters.list.push(listFields.eq(aqi).val()); }
                        }
                        else if(uploadFields){
                            for(aqi = 0; aqi < uploadFields.length; aqi++){ authorizedQ.parameters.upload.push(uploadFields[aqi]); }
                        }
                   }

                   cmdQuery = visitorQ;
               }
               else if(formError.length === 0 && !get_cookie('portalId')){
                    let visitorQ = {
                        type: 'send',
                        parameters: {
                            visitor: {
                                fn: $('#fn').val() + ' ' + $('#sn').val(),
                                country: $('#region').val(),
                                contactData: {
                                    email: $('#email').val(),
                                    phone: $('#phone').val()
                                }
                            },
                            text: [],
                            search: [],
                            list: [],
                            upload: []
                        }
                    };

                    
                   for(fi = 1; fi < fields.length; fi++){
                        textFields = fields.eq(fi).find('#default-field');
                        searchFields = fields.eq(fi).find('#search-field');
                        listFields = fields.eq(fi).find('#list-field');
                        uploadFields = JSON.parse(sessionStorage.getItem('uploaders'));

                        let aqv;

                        if(textFields){
                            for(aqv = 0; aqv < textFields.length; aqv++){ visitorQ.parameters.text.push(textFields.eq(aqv).val()); }
                        }
                        else if(searchFields){
                            for(aqv = 0; aqv < searchFields.length; aqv++){ visitorQ.parameters.search.push(searchFields.eq(aqv).val()); }
                        }
                        else if(listFields){
                            for(aqv = 0; aqv < listFields.length; aqv++){ visitorQ.parameters.list.push(listFields.eq(aqv).val()); }
                        }
                        else if(uploadFields){
                            for(aqv = 0; aqv < uploadFields.length; aqv++){ visitorQ.parameters.upload.push(uploadFields[aqv]); }
                        }
                   }

                    cmdQuery = visitorQ;
               }
               else{
                alertify.set('notifier','position', 'bottom-right');
                alertify.set('notifier','delay', 10);

                for(var i = 0; i < formError.length; i++){ errorContentForm += formError[i] + '\n\n'; }
                alertify.error(errorContentForm);
              }

               if(formError.length === 0){
                cmd.append('cmd', JSON.stringify(cmdQuery));

                alertify.set('notifier','position', 'top-right');
                alertify.set('notifier','delay', 10);
 
                fetch('/services/2/post?id=' + currentService, {method: 'POST', body: cmd})
                 .then(response => response.json())
                 .then(this.SuccessServiceResponse)
                 .catch(this.FailServiceResponse);
               }
            }
        });
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
                            <input type="file" id="upload-field" className={ ufd.fieldName } placeholer={ ufd.dExample } multiple />
                            <div id="upload-field-content">
                                <button>Upload files</button>
                                <span>Not uploaded files</span>
                            </div>
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
                            <input type="search" id="search-field" className={ sfd.fieldName } data-dSource={ sfd.dSource } data-dMethod={ sfd.dMethod } placeholer={ sfd.dExample } />
                        </label>
                    });

                    formContent = (
                        <>
                            <div id="header">{ newField.stepD }</div>
                            <div id="body">{ sfld }</div>
                        </>
                    );
                }
                else if(newField.type === 'queryContent'){
                    const sfld = newField.form.map((sfd) => {
                        <label>
                            <span>{ sfd.name }</span>
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
    findSearchData(query,done){
        var sf = new FormData();
        sf.append(this.className, query);

        fetch($(this).data('dSource'), {method: $(this).data('dMethod') ? 'GET' : 'POST', body: sf })
            .then(response => response.json())
            .then(data => done(data));
    }
    searchQueryGenerator(response){
        $(this).val(response.value);
        $(this).prop('disabled', true);
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
    SuccessServiceResponse(data){
        $('header#formUI > .formStep').html('<div class="finish-message success">Your request is in the queue for its consideration!</div>');
        $('main#formUI > .formStep').html('<div class="finish-message success"><img src="/images/icons/services-status/success.svg" /><p>After 10 seconds, you will be automatically redirected to the information page about the service from which you came to this page. During this time, you will see a block on the upper right corner with a notification about the successful sending of the request.</p></div>');
        $('footer#formUI > .formStep').remove();

        alertify.success(get_cookie('portalId') ? data.sendFinish.forAuth : data.sendFinish.forVisitor);
        window.setTimeout(function(){ window.location.assign('/services/' + currentService); }, 10000);
    }
    FailServiceResponse(error){
        $('header#formUI > .formStep').html('<div class="finish-message error">An error occurred in sending the request</div>');
        $('main#formUI > .formStep').html('<div class="finish-message error"><img src="/images/icons/services-status/error.svg" /><p>Within 10 seconds, you will see a window with the essence of the error in the upper right corner. Check your Internet connection and if the connection is stable, then disable the VPN if it is available on your network or device. With a stable connection, these are temporary problems in the infrastructure of the portal and its services, which are instantly eliminated. Try to enter and send the data again after a while by clicking on the button under this message that you are reading!</p></div>');
        $('footer#formUI > .formStep').html('<div class="finish-message error"><button>Input and query again</button></div>');

        alertify.error('Service send error:\n' + error + '\n Retry proccess again!');

        $('footer#formUI > .formStep .finish-message button').click(function(){ window.reload(true); });
    }
}

ReactDOM.render(<ServiceForm />, document.getElementById('svcForm'));
