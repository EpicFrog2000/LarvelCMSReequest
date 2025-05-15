<div id='elementStyleSettingsWindow' class="elementStyleSettingsWindow window">

    child grid xdddddd
    <hr>
    <h1>Layout</h1>
    <div class="layout-settings-container">
        <div style="display: flex; flex-direction: column;">
            <h2>Display:</h2>
            <div class="admin-tabsmenu-row-buttons" id="layout-options-buttons">
                <button class="admin-tab-button" id="block-button" value="block">
                    Block
                </button>
                <button class="admin-tab-button" id="flex-button" value="flex">
                    Flex
                </button>
                <button class="admin-tab-button" id="grid-button" value="grid">
                    Grid
                </button>
                <button class="admin-tab-button" id="none-button" value="none">
                    None
                </button>
            </div>
        </div>
        
        <div class="admin-tabs-content" id="layout-tabs-content">
            <div class="admin-tab-content" id="block-tab">
            </div>

            <div class="admin-tab-content" id="flex-tab">

                <div style="display: flex; flex-direction: row; border: 1px solid black;">
                    <h2>Direction:</h2>
                    <select id="flex-direction">
                        <option value="column">column</option>
                        <option value="row">row</option>
                        <option value="column-reverse">column-reverse</option>
                        <option value="row-reverse">row-reverse</option>
                    </select>
                </div>

                <div style="display: flex; flex-direction: row; border: 1px solid black;">
                    <h2>Align:</h2>
                    <div style="display: flex; flex-direction: column;">
                        <div class="admin-tabs-content" id="flex-direction-tabs-content">
                            <div class="admin-tab-content" id="column-tab">
                                <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px; border: 1px solid black;">
                                    <h2>Y (justify-content – vertical):</h2>
                                    <select id="column-y">
                                        <option value="flex-start">top (flex-start)</option>
                                        <option value="center">center</option>
                                        <option value="flex-end">bottom (flex-end)</option>
                                        <option value="space-between">space-between</option>
                                        <option value="space-around">space-around</option>
                                        <option value="space-evenly">space-evenly</option>
                                    </select>
                                </div>
                                <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px; border: 1px solid black;">
                                    <h2>X (align-items – horizontal):</h2>
                                    <select id="column-x">
                                        <option value="flex-start">left (flex-start)</option>
                                        <option value="center">center</option>
                                        <option value="flex-end">right (flex-end)</option>
                                        <option value="stretch">stretch</option>
                                        <option value="baseline">baseline</option>
                                        <option value="start">start</option>
                                        <option value="end">end</option>
                                        <option value="self-start">self-start</option>
                                        <option value="self-end">self-end</option>
                                    </select>
                                </div>
                                <div style="display: flex; flex-direction: column; border: 1px solid black;">
                                    <h2>gap:</h2>
                                    <h3>columns:<h3/>
                                    <input type="text" id="column-gap-columns" value="0px" placeholder="0px" style="border: 1px solid black;">
                                    <h3>rows:<h3/>
                                    <input type="text" id="column-gap-rows" value="0px" placeholder="0px" style="border: 1px solid black;">
                                </div>
                            </div>

                            <div class="admin-tab-content" id="row-tab">
                                <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px; border: 1px solid black;">
                                    <h2>X (justify-content – horizontal):</h2>
                                    <select id="row-x">
                                        <option value="flex-start">left (flex-start)</option>
                                        <option value="center">center</option>
                                        <option value="flex-end">right (flex-end)</option>
                                        <option value="space-between">space-between</option>
                                        <option value="space-around">space-around</option>
                                        <option value="space-evenly">space-evenly</option>
                                    </select>
                                </div>
                                <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px; border: 1px solid black;">
                                    <h2>Y (align-items – vertical):</h2>
                                    <select id="row-y">
                                        <option value="flex-start">top (flex-start)</option>
                                        <option value="center">center</option>
                                        <option value="flex-end">bottom (flex-end)</option>
                                        <option value="stretch">stretch</option>
                                        <option value="baseline">baseline</option>
                                        <option value="start">start</option>
                                        <option value="end">end</option>
                                        <option value="self-start">self-start</option>
                                        <option value="self-end">self-end</option>
                                    </select>
                                </div>
                                <div style="display: flex; flex-direction: column; border: 1px solid black;">
                                    <h2>gap:</h2>
                                    <h3>columns:<h3/>
                                    <input type="text" id="row-gap-columns" value="0px" placeholder="0px" style="border: 1px solid black;">
                                    <h3>rows:<h3/>
                                    <input type="text" id="row-gap-rows" value="0px" placeholder="0px" style="border: 1px solid black;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-tab-content" id="grid-tab">
                <div style="display: flex; flex-direction: column; width: 100%; max-width: 100%;">
                    <h2>grid:</h2>
                    <h3>columns:<h3/>
                    <input type="number" value="1" placeholder="1" min="1" style="width: 30%;" id="columnsInput">
                    <h3>rows:<h3/>
                    <input type="number" value="1" placeholder="1" min="1" style="width: 30%;" id="rowsInput">
                </div>
                <div style="display: flex; flex-direction: column;">
                    <h2>Direction:</h2>
                    <select id="grid-direction">
                        <option value="row">row</option>
                        <option value="column">column</option>
                    </select>
                </div>
                <div style="display: flex; flex-direction: column; width: 100%; max-width: 100%;">
                    <h2>Align:</h2>
                    <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px; border: 1px solid black; padding: 8px;">
                        <label for="grid-x"><strong>X (justify-items):</strong></label>
                        <select id="grid-x">
                            <option value="left">left</option>
                            <option value="center">center</option>
                            <option value="right">right</option>
                            <option value="stretch">stretch</option>
                            <option value="baseline">baseline</option>
                        </select>
                    </div>

                    <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px; border: 1px solid black; padding: 8px;">
                        <label for="grid-y"><strong>Y (align-items):</strong></label>
                        <select id="grid-y">
                            <option value="top">top</option>
                            <option value="center">center</option>
                            <option value="bottom">bottom</option>
                            <option value="stretch">stretch</option>
                            <option value="baseline">baseline</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; border: 1px solid black;">
                    <h2>gap:</h2>
                    <h3>columns:<h3/>
                    <input type="text" id="grid-gap-columns" value="0px" placeholder="0px" style="border: 1px solid black;">
                    <h3>rows:<h3/>
                    <input type="text" id="grid-gap-rows" value="0px" placeholder="0px" style="border: 1px solid black;">
                </div>
            </div>

            <div class="admin-tab-content" id="none-tab">
            </div>
        </div>
    </div>
    <hr>
    <h1>Spacing</h1>
    <div style="display: flex; flex-direction: column; border: 1px solid black;">
        <h3>margin-left:<h3/>
        <input type="text" id="margin-left" value="0px" placeholder="0px" style="border: 1px solid black;">
        <h3>margin-right:<h3/>
        <input type="text" id="margin-right" value="0px" placeholder="0px" style="border: 1px solid black;">
        <h3>margin-top:<h3/>
        <input type="text" id="margin-top" value="0px" placeholder="0px" style="border: 1px solid black;">
        <h3>margin-bottom:<h3/>
        <input type="text" id="margin-bottom" value="0px" placeholder="0px" style="border: 1px solid black;">
        <h3>padding-left:<h3/>
        <input type="text" id="padding-left" value="0px" placeholder="0px" style="border: 1px solid black;">
        <h3>padding-right:<h3/>
        <input type="text" id="padding-right" value="0px" placeholder="0px" style="border: 1px solid black;">
        <h3>padding-top:<h3/>
        <input type="text" id="padding-top" value="0px" placeholder="0px" style="border: 1px solid black;">
        <h3>padding-bottom:<h3/>
        <input type="text" id="padding-bottom" value="0px" placeholder="0px" style="border: 1px solid black;">
    </div>
    <hr>
    <h1>Size</h1>
    <h2>width:<h2/>
    <input type="text" id="width" value="0px" placeholder="0px" style="border: 1px solid black;">
    <h2>min width:<h2/>
    <input type="text" id="min-width" value="0px" placeholder="0px" style="border: 1px solid black;">
    <h2>max width:<h2/>
    <input type="text" id="max-width" value="0px" placeholder="0px" style="border: 1px solid black;">
    <h2>height:<h2/>
    <input type="text" id="height" value="0px" placeholder="0px" style="border: 1px solid black;">
    <h2>min height:<h2/>
    <input type="text" id="min-height" value="0px" placeholder="0px" style="border: 1px solid black;">
    <h2>max height:<h2/>
    <input type="text" id="max-height" value="0px" placeholder="0px" style="border: 1px solid black;">
    <h2>overflow:<h2/>
    <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 8px; border: 1px solid black; padding: 8px;">
        <label for="overflow"><strong>Overflow:</strong></label>
        <select id="overflow">
            <option value="visible">visible</option>
            <option value="hidden">hidden</option>
            <option value="cut">cut</option>
            <option value="scroll">scroll</option>
            <option value="auto">auto</option>
        </select>
    </div>

    sizeoptions
    ratio
    box size options
    fit
    fit position

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

    .admin-tab-button.selected{
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


    
</script>
