<div id='elementStyleSettingsWindow' class="elementStyleSettingsWindow window">

    child grid xdddddd
    <hr>
    <h1>Layout</h1>
    <div class="layout-settings-container">
        <div style="display: flex; flex-direction: column;">
            <h2>Display:</h2>
            <div class="admin-tabsmenu-row-buttons" id="layout-options-buttons">
                <button class="admin-tab-button" id="block-button">
                    Block
                </button>
                <button class="admin-tab-button" id="flex-button">
                    Flex
                </button>
                <button class="admin-tab-button" id="grid-button">
                    Grid
                </button>
                <button class="admin-tab-button" id="none-button">
                    None
                </button>
            </div>
        </div>
        
        <div class="admin-tabs-content" id="layout-tabs-content">
            <div class="admin-tab-content" id="block-tab">
            </div>

            <div class="admin-tab-content" id="flex-tab">

                <div style="display: flex; flex-direction: row;">
                    <h2>Direction:</h2>
                    <select name="Direction" id="flex-direction">
                        <option value="Column">Column</option>
                        <option value="Row">Row</option>
                        <option value="Left-Right-wrapDown">Left-Right-wrapDown</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div style="display: flex; flex-direction: row;">
                    <h2>Align:</h2>
                    <div style="display: flex; flex-direction: column;">
                        <div class="admin-tabs-content" id="flex-direction-tabs-content">
                            <div class="admin-tab-content" id="Column-tab">
                                <div style="display: flex; flex-direction: row;">
                                    <h2>X:</h2>
                                    <select name="x" id="x">
                                        <option value="left">left</option>
                                        <option value="centrer">centrer</option>
                                        <option value="right">right</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <div style="display: flex; flex-direction: row;">
                                    <h2>Y:</h2>
                                    <select name="y" id="y">
                                        <option value="Column">Column</option>
                                        <option value="Row">Row</option>
                                        <option value="Left-Right-wrapDown">Left-Right-wrapDown</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="admin-tab-content" id="Row-tab">
                                <div style="display: flex; flex-direction: row;">
                                    <h2>Y:</h2>
                                    <select name="y" id="y">
                                        <option value="Column">Column</option>
                                        <option value="Row">Row</option>
                                        <option value="Left-Right-wrapDown">Left-Right-wrapDown</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div style="display: flex; flex-direction: row;">
                                    <h2>X:</h2>
                                    <select name="x" id="x">
                                        <option value="left">left</option>
                                        <option value="centrer">centrer</option>
                                        <option value="right">right</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: row;">
                            <h2>gap:</h2>
                            <input type="text" name="gap" value="0px" placeholder="0px">
                        </div>
                    </div>
                </div>
            </div>


            <div class="admin-tab-content" id="grid-tab">
                <div style="display: flex; flex-direction: row; width: 100%; max-width: 100%;">
                    <h2>grid:</h2>
                    <input type="number" name="columns" value="1" placeholder="1" min="1" style="width: 30%;">
                    <input type="number" name="rows" value="1" placeholder="1" min="1" style="width: 30%;">
                </div>
                <div style="display: flex; flex-direction: row;">
                    <h2>Direction:</h2>
                    <select name="direction" id="direction">
                        <option value="Horizontal">Horizontal</option>
                        <option value="Vertical">Vertical</option>
                    </select>
                </div>







            </div>



            <div class="admin-tab-content" id="none-tab">
            </div>
        </div>

    </div>



    <hr>
    Spacing - Margin Padding
    <hr>
    Size
    width height min max overflow sizeoptions
    <hr>
    position
    <hr>
    typography
    <hr>
    backgrounds
    <hr>
    borders
    <hr>
    effects
    <hr>
    custom properties

    ALE Z TYM ROBOTY BEDZIE OMG

</div>

<style>
    .admin-tabsmenu-row-buttons{
        display: flex;
        flex-direction: row;
    }

    .admin-tab-button{
        background-color: grey;
        padding: 5px;
    }

    .admin-tab-button:hover{
        background-color: lightgray;
    }

    .elementStyleSettingsWindow{
        display: flex;
        flex-direction: column;
        padding: 5px;
    }

    .layout-settings-container{
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .options-row-container{
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        
    }

    .admin-tabs-content{
        display: grid;
    }

    .admin-tab-content{
        grid-row: 1 / 1;
        grid-column: 1 / 1;
        display: none;
        float: left;
    }

    .admin-tab-content.visible{
        display: flex;
        flex-direction: column;
        align-items: start;
    }


</style>

<script>
    


    initTabswithButtons('layout-options-buttons', 'layout-tabs-content');
    initTabswithSelect('flex-direction', 'flex-direction-tabs-content');

    
    function initTabswithButtons(buttons_container_id, tabs_container_id){
        const buttons = document.getElementById(buttons_container_id).children;
        const tabs = document.getElementById(tabs_container_id).children;
        Array.from(buttons).forEach(button => {
            button.addEventListener('click', () => {
                let chosen_tab = document.getElementById(button.id.split('-')[0] + "-tab");
                chosen_tab.classList.add('visible');
                Array.from(tabs).forEach(tab => {
                    if(tab != chosen_tab){
                        tab.classList.remove('visible');
                    }
                });
            });
        });
    }

    function initTabswithSelect(select_element_id, tabs_container_id){
        const select_element = document.getElementById(select_element_id);
        const tabs = document.getElementById(tabs_container_id).children;
        select_element.addEventListener("change", function () {
            const selectedValue = this.value;
            let chosen_tab = document.getElementById(selectedValue.split('-')[0] + "-tab");
            chosen_tab.classList.add('visible');
            Array.from(tabs).forEach(tab => {
                if(tab != chosen_tab){
                    tab.classList.remove('visible');
                }
            });
        });
    }







</script>