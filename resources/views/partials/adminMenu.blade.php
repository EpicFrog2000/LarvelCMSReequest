<div style="display: flex; flex-direction: row; width: auto; text-wrap-mode: nowrap;" id="adminMenu">
  <div class="tab">
    <button class="tablinks" id="Ustawienia Elementu" onclick="openAdvancedOptions(event, 'UstawieniaElementu')" style="border: solid 1px; black; padding: 5px;">Ustawienia Elementu</button>
      <div id="UstawieniaElementu" class="tabcontent">
      </div>
  </div>
  <div id="ListaElementów" class="tab" style="background-color: #f1f1f1; display: none;"></div>
  <div id="ListaContainerów" class="tab" style="background-color: #f1f1f1; display: none;"></div>
</div>


<div style="position: fixed; right: 20px; bottom: 20px;">
  <button class="save-button" onclick="zapiszWyswig()">ZAPISZ</button>
</div>





<style>

.save-button {
    background-color: red;
    padding: 9px 20px;
    color: white;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

.save-button:hover {
  background-color: darkred;
}



* {box-sizing: border-box}

/* Style the tab */
.tab {
  float: left;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  width: 100%;
  height: auto;
}

/* Style the buttons that are used to open the tab content */
.tab button {
  display: block;
  background-color: inherit;
  color: black;
  padding: 22px 16px;
  width: 100%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  float: left;
  width: 100%;
  border-left: none;
  height: auto;
}
</style>

<script>

function openAdvancedOptions(evt, tabname) {
  const targetTab = document.getElementById(tabname);
  const isActive = targetTab.style.display === "block";

  clearTabs();

  if (isActive) {
    evt.currentTarget.classList.remove("active");
    return;
  }

  const buttons = getButtonyUstawienElementu();
  buttons.forEach(button => targetTab.appendChild(button));

  targetTab.style.display = "block";
  evt.currentTarget.classList.add("active");
}

function clearTabs() {
  const tabcontents = document.querySelectorAll('.tabcontent');
  tabcontents.forEach(tab => {
    tab.innerHTML = '';
    tab.style.display = "none";
  });

  const tablinks = document.querySelectorAll('.tablinks');
  tablinks.forEach(link => link.classList.remove("active"));


  const tabs = document.querySelectorAll('.tab');
  tabs.forEach(tab => {
    if (tab.id) {
      tab.style.display = 'none';
    }
  });
}



</script>