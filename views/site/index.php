<?php
$this->title = 'Currency Calculator App';
?>

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="row mt-2">
    <div class="col"></div>
    <div class="col-10">

        <?php   
            $form = ActiveForm::begin(
                [
                    'options' => [
                        'class' => 'form-inline',
                    ]
                ]
            ); 
        ?>

        <div class="form-group mr-2">
        <?= 
            $form->field($model, 'value')->textInput([
                'maxlength' => 20, 
                'class' => 'form-control',
            ])->label('Amount', ['class' => 'label'])->error(false); 
        ?>
        </div>

        <div class="form-group mr-2">
        <?= Html::activeLabel($model, 'baseCountry', ['class' => 'label']) ?>
        <?= Html::activeDropDownList($model, 'baseCountry', $countries, ['class' => 'custom-select']) ?>
        </div>

        <div class="form-group mr-2">
        <?= Html::activeLabel($model, 'destinationCountry', ['class' => 'label']) ?>
        <?= Html::activeDropDownList($model, 'destinationCountry', $countries, ['class' => 'custom-select']) ?>
        </div>

        <div class="form-group mr-2">
            <?= Html::submitButton('Calculate', ['class' => 'btn btn-primary']) ?>
        </div>

        <div class="row text-center m-3">
            <?= $form->errorSummary($model, ['attributes' => ['text']])?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="col"></div>
</div>

<?php if (isset($results)) { ?>
<div class="row">
    <div class="col-2"></div>
    <div class="col-8 mt-5">
        <h2 class="text-center">Results</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>From Currency</th>
                    <th>To Currency</th>
                    <th>Base Amount</th>
                    <th>Result Amount</th>
                </tr>
            </thead>
            <tbody>
                <td>
                <?php if (isset($results['fromCurrency']) && isset($currencies[$results['fromCurrency']])) { echo $currencies[$results['fromCurrency']]['currencyName'] . ' [' . $results['fromCurrency'] . ']'; } ?>             
                </td>
                <td>
                <?php if (isset($results['toCurrency']) && isset($currencies[$results['toCurrency']])) { echo $currencies[$results['toCurrency']]['currencyName'] . ' [' . $results['toCurrency'] . ']'; } ?>                   
                </td> 
                <td>
                <?php if (isset($results['baseAmount'])) { echo $results['baseAmount']; } ?>                    
                </td>  
                <td>
                    <strong>
                        <?php if (isset($results['resultAmount'])) { echo $results['resultAmount']; } ?>
                    </strong>                 
                </td>  
            </tbody>
        </table>
    </div>
    <div class="col-2"></div>
</div>
<?php } ?>