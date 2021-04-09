<?php

//print_r($form_model->stateListFixer());

use yii\helpers\Url;

?>
<style>
    .table th {
        font-weight: 600;
        background: #0069d9;
        color: #fff;
    }
</style>
<div id="app" class="page-content-wrapper mt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container ">
                            <div class="table-responsive-sm">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th width="80">S. No.</th>
                                            <th>Court Name</th>
                                            <th>Bench (If Applicable)</th>
                                            <th>Number of records</th>
                                            <th>Full Info</th>
                                        </tr>
                                        <tr v-for="(item, index,key) in stateList">
                                            <td> {{ key+1 }}</td>
                                            <td>
                                                <a :href="`<?= Url::to(['dashboard/court', 'court' => '']) ?>${item}`" target="_blank"> {{ item }}
                                                </a>
                                            </td>
                                            <td>
                                                {{item.includes('Bench') ? "Yes" : '-'}}

                                            </td>

                                            <td>
                                                <card-item :urltogo="`<?= Url::to(['dashboard/court','court' => '']) ?>${item}`"   :url="`${targetFinder(item)}`"></card-item>

                                            </td>

                                            <td>
                                             <card-item isfullinfo  :urltogo="`<?= Url::to(['dashboard/full-info','court' => '']) ?>${item}`" :url="`${targetFinder(item)}`"></card-item>  
                                            </td>


                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
    <!-- end container-fluid -->
</div>
<script src="https://unpkg.com/vue"></script>
<script src="<?= $this->theme->getUrl('comp/card-item.js') ?>"></script>

<script>
    console.log("...", []);
    var app = new Vue({
        el: '#app',

        data: {
            isLoading: false,
            stateList: <?= json_encode($form_model->stateListFixer()) ?>,
            hasError: false,
            totalRecordsUrl: "<?=Yii::$app->params['countApiUrl'] . "?target="?>"
        },
        methods: {
            fetchByUrl: async function(url) {
                return await fetch(url)
            },
            targetFinder: function(item) {
                let toReturn ="NA"
                Object.keys(this.stateList)?.map(court=>{
                    if(this.stateList[court] ===item){
                         toReturn= `<?=Yii::$app->params['countApiUrl']?>?target=${court}`
                        
                    }
                     

                })
            
                return toReturn

            }

        },
        beforeMount() {
            

        }
    })
</script>