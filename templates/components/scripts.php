<script>
    let clientIds=new Array();
    let clients=new Array();
    let cbs=new Array();
    const body=document.getElementById('tbody');
    const cball=document.getElementById('selall');
    const rec=document.getElementById('recipients');
    const ids=document.getElementById('ids');
    const children=body.getElementsByTagName("*");
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
        let usetemplate=document.getElementById('usetemplate');
        let message=document.getElementById('message');
        let select=document.getElementById('select');
        if(usetemplate.checked){}
            message.innerHTML=select.value;
        message.disabled=usetemplate.checked;
        select.disabled=!(usetemplate);
    }
    function submit(event){
        event.preventDefault();
        document.getElementById('sendsms').submit();
        event.target.disabled=true;
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

			window.onclick = function (event) {
				if (event.target == modal) modalClose();
			}
		}
    </script>
    