<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VwRealisasiDetail;

/**
 * VwRealisasiDetailSearch represents the model behind the search form of `app\models\VwRealisasiDetail`.
 */
class VwRealisasiSearch extends VwRealisasiDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_rab', 'tgl_rab'], 'safe'],
            [['id_d_rab', 'hari_kerja', 'hari_kerja_realisasi'], 'integer'],
            [['qty', 'Total_rp', 'qty_realisasi', 'total_rp_realisasi'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = VwRealisasiDetail::find() ->select(['no_rab','tgl_rab','qty'=>'sum(isnull(qty,0))','hari_kerja'=>'sum(isnull(hari_kerja,0))',
        'Total_rp'=>'sum(isnull(total_rp,0))', 'qty_realisasi' => 'sum(isnull(qty_realisasi,0))', 'hari_kerja_realisasi' => 'sum(isnull(hari_kerja_realisasi,0))',
            'total_rp_realisasi' => 'sum(isnull(total_rp_realisasi,0))'
        ])
        ->groupBy([ 'no_rab', 'tgl_rab'])      ;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'tgl_rab' => $this->tgl_rab,
            'id_d_rab' => $this->id_d_rab,
            'qty' => $this->qty,
            'hari_kerja' => $this->hari_kerja,
            'Total_rp' => $this->Total_rp,
            'qty_realisasi' => $this->qty_realisasi,
            'hari_kerja_realisasi' => $this->hari_kerja_realisasi,
            'total_rp_realisasi' => $this->total_rp_realisasi,
        ]);

        $query->andFilterWhere(['like', 'no_rab', $this->no_rab])
            ->andFilterWhere(['like', 'kode_pekerjaan', $this->kode_pekerjaan])
            ->andFilterWhere(['like', 'nama_pekerjaan', $this->nama_pekerjaan]);

        return $dataProvider;
    }
}
