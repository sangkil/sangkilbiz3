<?php

namespace biz\accounting\components;

use biz\accounting\models\EntriSheet;
use biz\accounting\models\Coa;
use biz\accounting\models\GlHeader;
use biz\accounting\models\GlDetail;
use biz\accounting\models\Invoice;
use biz\accounting\models\InvoiceDtl;
use biz\accounting\models\AccPeriode;
use yii\base\UserException;

/**
 * Description of Helper
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class Helper
{

    /**
     *
     * @param  string        $name   Entri Sheet name
     * @param  array         $values
     * @return array
     * @throws UserException
     */
    public static function entriSheetToGlMaps($name, $values)
    {
        $gl_dtls = [];
        $esheet = EntriSheet::findOne(['nm_esheet' => $name]);
        if ($esheet) {
            foreach ($esheet->entriSheetDtls as $eDtl) {
                $coa = $eDtl->id_coa;
                $nm = $eDtl->nm_esheet_dtl;

                $dc = $eDtl->idCoa->normal_balance == 'D' ? 1 : -1;

                if (isset($values[$nm])) {
                    $ammount = $dc * $values[$nm];
                } else {
                    throw new UserException("Required account $nm ");
                }
                $gl_dtls[] = [
                    'id_coa' => $coa,
                    'ammount' => $ammount
                ];
            }
        } else {
            throw new UserException("Entrysheet $name not found");
        }

        return $gl_dtls;
    }

    private static function getCoaChild(&$result, $parent, $prefix, $tab)
    {
        foreach (Coa::find()->where(['id_parent' => $parent])->orderBy(['cd_account' => SORT_ASC])->all() as $row) {
            $result[$row['id_coa']] = $prefix . "[{$row['cd_account']}] {$row['nm_account']}";
            static::getCoaChild($result, $row['id_coa'], $prefix . $tab, $tab);
        }
    }

    public static function getGroupedCoaList($addSelf = false, $tab = 4)
    {
        $result = [];
        $tab = str_pad('', $tab);
        foreach (Coa::find()->where(['id_parent' => null])->orderBy(['cd_account' => SORT_ASC])->all() as $row) {
            if ($addSelf) {
                $result[$row['nm_account']][$row['id_coa']] = "[{$row['cd_account']}] {$row['nm_account']}";
            } else {
                $result[$row['nm_account']] = [];
            }
            static::getCoaChild($result[$row['nm_account']], $row['id_coa'], $addSelf ? $tab : '', $tab);
        }

        return $result;
    }

    /**
     * @return array()
     */
    public static function getBalanceType()
    {
        return [
            'D' => 'DEBIT',
            'K' => 'KREDIT',
        ];
    }

    public static function getNormalBalanceOfType($coa_type)
    {
        $maps = [
            100000 => 'D',
            200000 => 'K',
            300000 => 'K',
            400000 => 'K',
            500000 => 'D',
            600000 => 'D'
        ];

        return $maps[(int) $coa_type];
    }

    /**
     * @return integer Current accounting periode
     */
    public static function getCurrentIdAccPeriode()
    {
        $acc = AccPeriode::findOne(['status' => AccPeriode::STATUS_OPEN]);
        if ($acc) {
            return $acc->id_periode;
        }
        throw new UserException('Periode tidak ditemukan');
    }

    /**
     * @return integer
     */
    public static function getAccountByName($name)
    {
        $coa = Coa::findOne(['lower(nm_account)' => strtolower($name)]);
        if ($coa) {
            return $coa->id_coa;
        }
        throw new UserException('Akun tidak ditemukan');
    }

    /**
     * @return integer
     */
    public static function getAccountByCode($code)
    {
        $coa = Coa::findOne(['lower(cd_account)' => strtolower($code)]);
        if ($coa) {
            return $coa->id_coa;
        }
        throw new UserException('Akun tidak ditemukan');
    }

    public static function createGL($hdr, $dtls = [])
    {
        $blc = 0.0;
        foreach ($dtls as $row) {
            $blc += $row['ammount'];
        }
        if ($blc != 0) {
            throw new UserException('GL Balance Failed');
        }

        $gl = new GlHeader();
        $gl->gl_date = $hdr['date'];
        $gl->id_reff = $hdr['id_reff'];
        $gl->type_reff = $hdr['type_reff'];
        $gl->description = $hdr['description'];

        $gl->id_branch = $hdr['id_branch'];

        /*
         * Edited By Mujib Masyhudi
         * on 2014-07-07
         */
        $active_periode = self::getCurrentIdAccPeriode();
        $gl->id_periode = $active_periode['id_periode'];
        $gl->status = 0;

        if (!$gl->save()) {
            throw new UserException(implode("\n", $gl->getFirstErrors()));
        }

        foreach ($dtls as $row) {
            $glDtl = new GlDetail();
            $glDtl->id_gl = $gl->id_gl;
            $glDtl->id_coa = $row['id_coa'];
            $glDtl->amount = $row['ammount'];
            if (!$glDtl->save()) {
                throw new UserException(implode("\n", $glDtl->getFirstErrors()));
            }
        }
    }

    public static function createInvoice($params)
    {
        $invoice = new Invoice();
        $invoice->id_vendor = $params['id_vendor'];
        $invoice->invoice_date = $params['date'];
        $invoice->invoice_value = $params['value'];
        $invoice->invoice_type = $params['type'];
        $invoice->due_date = date('Y-m-d', strtotime('+1 month'));
        $invoice->status = 0;
        if (!$invoice->save()) {
            throw new UserException(implode("\n", $invoice->getFirstErrors()));
        }

        $invDtl = new InvoiceDtl();
        $invDtl->id_invoice = $invoice->id_invoice;
        $invDtl->id_reff = $params['id_ref'];
        $invDtl->trans_value = $params['value'];
        if (!$invDtl->save()) {
            throw new UserException(implode("\n", $invDtl->getFirstErrors()));
        }
    }
}
