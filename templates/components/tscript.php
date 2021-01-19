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
    
    const message=document.getElementById('message');
    const tname=document.getElementById('tname');
    const cost=document.getElementById('cost');
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
    message.addEventListener('input',event=>updateCost());
    function fadeopen(node){
        node.classList.remove('fadeOut');
        node.classList.add('fadeIn');
        node.style.display = 'flex';
    }
    
    function fadeclose(node){
        node.classList.remove('fadeIn');
        node.classList.add('fadeOut');
        setTimeout(() => {
            node.style.display = 'none';
        }, 500);
    }

    const openModal = () => {
        modal.classList.remove('fadeOut');
        modal.classList.add('fadeIn');
        modal.style.display = 'flex';
    }

    for (let i = 0; i < closeButton.length; i++) {

        const elements = closeButton[i];

        elements.onclick = (e) => modalClose();

        modal.style.display = 'none';

    }
    function dropup(node){
        node.nextElementSibling.classList.remove('hidden');
    }
    function delcon(id){
        if(confirm('Are you sure to delete the selected template?')){
            window.location.href='public.php?templating&deltemplate='+id;
        }
    }
    function insertvar(node,varname){
        message.value+="{{ "+varname+" }}";
        node.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.classList.add('hidden')
    }
    let title=document.getElementById('modalTitle');
    let button=document.getElementById('but');
    function addtemp(){
        title.innerText="Add SMS Template";
        but.innerText="Add Template";
        message.value='';
        tname.value='';
        but.name="addt";
        openModal(modal);
    }
    function validate(){
        let rfile=document.getElementById('rfile');
        let fileName = rfile.value;
        if(fileName){
            let ext = fileName.substring(fileName.lastIndexOf('.') + 1).toLowerCase();
            if(ext==='json'){
                return confirm('Template will be overwritten, Continue?');
            }
            alert('only json file was allowed');
            return false;
        }
        alert('select template first');
        return false;
    }   
    function updatetemp(val,node){
        title.innerText="Edit SMS Template";
        but.innerText="Update Template";
        let mess=node.parentNode.previousSibling.innerText;
        let nam=node.parentNode.previousSibling.previousSibling.innerText;
        but.name="upt";
        message.value=mess;
        tname.value=nam;
        but.value=val;
        openModal(modal);
    }
</script>