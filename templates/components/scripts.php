<script>
    let clientIds=new Array();
    let clients=new Array();
    let cbs=new Array();
    const usetemplate=document.getElementById('usetemplate');
    const message=document.getElementById('message');
    const cost=document.getElementById('cost');
    const select=document.getElementById('select');
    const body=document.getElementById('tbody');
    const cball=document.getElementById('selall');
    const rec=document.getElementById('recipients');
    const ids=document.getElementById('ids');
    const children=body.getElementsByTagName("*");
    const sendbutton=document.getElementById('sendbutton');
    for(let i=0;i<children.length;i++){
        if(children[i].nodeName==='INPUT'){
            cbs.push(children[i]);
            children[i].addEventListener('change',(event)=>{
                let company=event.target.parentNode.nextSibling.nextSibling.firstChild.innerText;
                if(event.target.checked){
                    clientIds.push(event.target.value);
                    clients.push(company);
                    rec.innerText=clients.join();
                }
                else{
                    clientIds.splice(clientIds.indexOf(event.target.value),1)
                    clients.splice(clients.indexOf(company),1)
                    rec.innerText=clients.join();
                }
                cball.checked=isAll();
                ids.value=clientIds;
            })
        }
    }
    function updateCost(){
        let creditcost=0;
        let count=message.value.length;
        let credit=0;
        if(count>0 && count<=160) credit=1;
        else if(count>160 && count<=306) credit=2;
        else if(count>306 && count<=459) credit=3;
        else if(count>459 && count<=640) credit=4;
        cost.innerHTML=credit!==0?credit+' credit/s':'out of range'
    }

    function toggleall(e){
        clients=new Array();
        clientIds=new Array();
        for(let i=0;i<cbs.length;i++){
            cbs[i].checked=e.target.checked;
            let company=cbs[i].parentNode.nextSibling.nextSibling.firstChild.innerText;
            if(e.target.checked){
                clientIds.push(cbs[i].value);
                clients.push(company);
                rec.innerText=clients.join();
            }
            else{
                clientIds.splice(clientIds.indexOf(cbs[i].value),1)
                clients.splice(clients.indexOf(company),1)
                rec.innerText=clients.join();
            }
                ids.value=clientIds;
        }
    }
    function isAll(){
        for(let i=0;i<cbs.length;i++){
            if(!cbs[i].checked)
                return false;
        }
        return true;
    }
    function pager(page){
        window.location.href='public.php?page='+page;
    }
    function templated(){
        if(usetemplate.checked){
            message.value=select.value;
        }
        else{
            message.value="";
        }
        message.disabled=usetemplate.checked;
        select.disabled=!(usetemplate.checked);
        updateCost();
    }
    function insertvar(node,varname){
        if(usetemplate.checked){
            return alert("cant add on templated mode")
        }
        message.value+="{{ "+varname+" }}";
        node.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.classList.add('hidden')
    }
    function submit(event){
        event.preventDefault();
        document.getElementById('sendsms').submit();
        event.target.disabled=true;
    }
    function fadeclose(node){
        node.classList.remove('fadeIn');
        node.classList.add('fadeOut');
        setTimeout(() => {
            node.style.display = 'none';
        }, 500);
    }
    function fadeopen(node){
        node.classList.remove('fadeOut');
        node.classList.add('fadeIn');
        node.style.display = 'flex';
    }
    function sendit(){
        sendbutton.disabled=true;
        sendbutton.style.cursor="wait";
        return true;
    }


</script>
<script>
		const modal = document.querySelector('.main-modal');
		const closeButton = document.querySelectorAll('.modal-close');

		const modalClose = () => {
			modal.classList.remove('fadeIn');
			modal.classList.add('fadeOut');
			setTimeout(() => {
				modal.style.display = 'none';
			}, 500);
		}

		const openModal = () => {
            if(clients.length>0){
                modal.classList.remove('fadeOut');
                modal.classList.add('fadeIn');
                modal.style.display = 'flex';
            }
            else
                alert('Please select at least one client to proceed with texting!')
		}

		for (let i = 0; i < closeButton.length; i++) {

			const elements = closeButton[i];

			elements.onclick = (e) => modalClose();

			modal.style.display = 'none';

		}
    </script>
    