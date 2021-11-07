<?php

    switch($type){

        case "select":

            $id = $settings['id'];
            $label = $settings['label'];
            $defaultSelected = isset($settings['defaultSelected']) ? $settings['defaultSelected'] : null;
            $dataSet = $settings['data'];
            $liveData = [];
            $valueCol = isset($settings['valueCol']) ? $settings['valueCol'] : 'value';
            $displayCol = isset($settings['displayCol']) ? $settings['displayCol'] : 'display';
            $attributes = isset($settings['attributes']) ? " ".$settings['attributes'] : '';

            
            foreach($dataSet as $data){

                $liveData[] = [
                
                    'value' => $data[$valueCol],
                    'display' => $data[$displayCol],
                    'optionAttr' => @$data['optionAttr']

                ];


            }
            

            ?>


            <div class="form-group<?= $errors !== null && $errors->has($id) ? ' has-danger' : '' ?>">
                <label class="form-control-label" for="<?= $id ?>"><?= $label ?></label>
                <select class="form-select form-control-alternative" name="<?= $id ?>"{{ $attributes }}>
                    <option>Select...</option>

                    <?php foreach($liveData as $data): 

                        $disabledClause = @$settings['defaultSelected']."" === $data['value']."" ? " selected" : "";

                    ?>
                    
                    <option <?= @$data['optionAttr'] ?> value='<?= $data['value'] ?>' <?= $disabledClause ?>><?= $data['display'] ?></option>

                    <?php endforeach; ?>
             
                </select>
            </div>

            <?php

        break;

        case "textarea":

            $value = isset($settings['value']) ? $settings['value'] : '';
            $label = $settings['label'];
            $id = $settings['id'];
            $placeholder = @$settings['placeholder'];
            $classes = isset($settings['classes']) ? " ".$settings['classes'] : '';
            $attributes = isset($settings['attributes']) ? " ".$settings['attributes'] : '';

        ?>

        <div class="form-group<?= $errors !== null && @$errors->has($id) ? ' has-danger' : '' ?>">
            <label class="form-control-label" for="<?= $id ?>"><?= $label ?></label>
            <textarea class='form-control{{ $classes }}' name='<?= $id ?>' value='' placeholder='<?= $placeholder ?>'{{ $attributes }}>{{ old($id,$value) }}</textarea>
        </div>

        <?php

        break;

        case "input":

            $value = isset($settings['value']) ? $settings['value'] : '';
            $label = $settings['label'];
            $id = $settings['id'];
            $placeholder = @$settings['placeholder'];
            $type = isset($settings['type']) ? $settings['type'] : 'text';
            $classes = isset($settings['classes']) ? " ".$settings['classes'] : '';
            $attributes = isset($settings['attributes']) ? " ".$settings['attributes'] : '';

            ?>

            <div class="form-group<?= $errors !== null && @$errors->has($id) ? ' has-danger' : '' ?>">
                <label class="form-control-label" for="<?= $id ?>"><?= $label ?></label>
                <input class='form-control{{ $classes }}' name='<?= $id ?>' value='{{ old($id,$value) }}' type='<?= $type ?>' placeholder='<?= $placeholder ?>'{{ $attributes }}>
            </div>

            <?php

        break;
    }

?>