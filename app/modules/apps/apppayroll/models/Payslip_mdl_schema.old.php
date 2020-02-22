<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.


  class Hello
  {
  private static $greeting = 'Hello';
  private static $initialized = false;

  private static function initialize()
  {
  if (self::$initialized)
  return;

  self::$greeting .= ' There!';
  self::$initialized = true;
  }

  public static function greet()
  {
  self::initialize();
  echo self::$greeting;
  }
  }

  Hello::greet(); // Hello There!

 */

class Payslip_Mdl_Schema {

    private static $initialized = false;

    private static function initialize() {
        if (self::$initialized) {
            return;
        }
    }

    public static function get_init_insert($tbl, $year, $month, $lastdate, $excl_ids_str) {
        return <<<SQL
        INSERT INTO {$tbl} (
                print_dt,
                empl_id,
                nipp,
                empl_name,
                gender,
                pob,
                dob,
                empl_gr,
                hire_date,
                los,
                kode_peringkat,
                created,
                modified
            )
                SELECT
                    '{$year}-{$month}-{$lastdate}',
                    rp.id_pegawai,
                    rp.nip_baru,
                    rp.nama_pegawai,
                    rp.gender,
                    rp.tempat_lahir,
                    rp.tanggal_lahir,
                    rp.kelompok_pegawai,
                    rp.tgl_terima,
                    MAX(IFNULL(rpg.mk_peringkat,0)) mk_peringkat,
                    rpg.kode_golongan,
                    NOW(),
                    NOW()
                FROM r_pegawai rp
                    LEFT JOIN r_peg_golongan  rpg ON rpg.id_pegawai = rp.id_pegawai
                    {$excl_ids_str}
                GROUP BY rp.id_pegawai;
SQL;
    }

    public static function get_locked_id($tbl, $print_dt) {
        return <<<SQL
        SELECT empl_id
            FROM {$tbl}
            WHERE print_dt = '{$print_dt}'
                AND `lock` = '1';
SQL;
    }

    public static function get_resignation_id($tbl, $year, $month, $datefield) {
        return <<<SQL
        SELECT id_pegawai
            FROM {$tbl}
            WHERE '{$year}-{$month}-01' > {$datefield}
SQL;
    }

    public static function get_update_base_salary($tbl, $tbl_join, $year, $month, $lastdate) {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.tahun,
                    a.id_gaji_pokok,
                    a.gaji_pokok,
                    a.gaji_pokok * 0.005780347 sal_perhour,
                    a.kode_golongan,
                    a.mk_peringkat,
                    a.status
                FROM `{$tbl_join}`  a


            ) ab
            ON r.los = ab.mk_peringkat
                AND r.grade_id = ab.kode_golongan
                AND YEAR(r.print_dt) >= ab.tahun
            SET
                r.base_sal_id = ab.id_gaji_pokok,
                r.base_sal = ab.gaji_pokok,

                r.base_sal_perhour = ab.sal_perhour,
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

    // TODO: add documentation
    public function get_update_ddc_pph21($tbl, $year, $month, $lastdate,  $default)
    {
        return <<<SQL
        UPDATE {$tbl} r
        SET
            `r`.`tax_ddc` =
                IF(IFNULL(r.tax_annual, 0) > 0,  r.tax_annual / 12, 0)
            ,
            `r`.`ddc_pph21` =
                IF(IFNULL(r.tax_annual, 0) > 0,  r.tax_annual / 12, 0)
            ,
            `r`.`alw_pph21` =
                IF(IFNULL(r.tax_annual, 0) > 0,  r.tax_annual / 12, 0)
            ,
            r.modified = NOW()
        WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
            AND `lock` = '0';
SQL;
    }

    public static function get_update_grade($tbl, $tbl_join, $year, $month, $lastdate)
    {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.sk_tanggal,
                    a.id_pegawai,
                    a.kode_golongan,
                    a.nama_pangkat
                FROM `{$tbl_join}` a
                    INNER JOIN (
                    SELECT
                        id_pegawai,
                        count(id_pegawai) cnt,
                        sk_tanggal,
                        max(sk_tanggal) maxsk
                    FROM `{$tbl_join}`
                    WHERE
                        sk_tanggal <= '{$year}-{$month}-{$lastdate}'
                    GROUP BY id_pegawai
                    ORDER BY
                        id_pegawai,
                        sk_tanggal DESC
                ) b
                ON
                    a.id_pegawai=b.id_pegawai
                    AND
                    a.sk_tanggal = b.maxsk
                    AND
                    a.sk_tanggal <= '{$year}-{$month}-{$lastdate}'
                ORDER BY
                    a.id_pegawai,
                    a.sk_tanggal DESC
            ) ab
            ON r.empl_id = ab.id_pegawai
            SET
                r.grade_id = ab.kode_golongan,
                r.grade = ab.nama_pangkat,
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

    //marital status for married alw
    public static function get_update_marstat($tbl, $tbl_join, $year, $month, $lastdate) {
//        return <<<SQL
//        UPDATE {$tbl} r
//            INNER JOIN (
//                SELECT
//                    a.tanggal_menikah,
//                    a.id_pegawai
//                FROM `{$tbl_join}` a
//                    INNER JOIN (
//                    SELECT
//                        id_pegawai,
//                        count(id_pegawai) cnt,
//                        tanggal_menikah,
//                        max(tanggal_menikah) maxsk
//                    FROM `{$tbl_join}`
//                    WHERE
//                        tanggal_menikah <= '{$year}-{$month}-{$lastdate}'
//                    GROUP BY id_pegawai
//                    ORDER BY
//                        id_pegawai,
//                        tanggal_menikah DESC
//                ) b
//                ON
//                    a.id_pegawai=b.id_pegawai
//                    AND
//                    a.tanggal_menikah = b.maxsk
//                    AND
//                    a.tanggal_menikah <= '{$year}-{$month}-{$lastdate}'
//                ORDER BY
//                    a.id_pegawai,
//                    a.tanggal_menikah DESC
//            ) ab
//            ON r.empl_id = ab.id_pegawai
//            SET
//                r.mar_stat = 'Menikah',
//                r.modified = NOW()
//            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
//                AND `lock` = '0';
//SQL;
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.eff_date,
                    a.empl_id,
                    a.mar_stat,
                    a.alw_rc_sp_cnt
                FROM `{$tbl_join}` a
                    INNER JOIN (
                    SELECT
                        empl_id,
                        count(empl_id) cnt,
                        eff_date,
                        max(eff_date) maxsk
                    FROM `{$tbl_join}`
                    WHERE
                        eff_date <= '{$year}-{$month}-{$lastdate}'
                        AND IF (term_date IS NULL,
                        TRUE,
                        '{$year}-{$month}-{$lastdate}' > term_date
                        )
                        AND active_status=1
                    GROUP BY empl_id
                    ORDER BY
                        empl_id,
                        eff_date DESC
                ) b
                ON
                    a.empl_id=b.empl_id
                    AND
                    a.eff_date = b.maxsk

                ORDER BY
                    a.empl_id,
                    a.eff_date DESC
            ) ab
            ON r.empl_id = ab.empl_id
            SET
                r.mar_stat = ab.mar_stat,
                r.alw_rc_sp_cnt = ab.alw_rc_sp_cnt,
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

    public static function get_update_child_count($tbl, $tbl_join, $year, $month, $lastdate, $empl_id = null) {
        $q_empl_id  = "";
        $q_empl_id2 = "";
        $q_empl_id3 = "";
        if ($empl_id) {
            $q_empl_id  = "empl_id='{$empl_id}'";
            $q_empl_id2 = "AND a.".$q_empl_id;
            $q_empl_id3 = "AND r.".$q_empl_id;
            $q_empl_id  = "AND ".$q_empl_id;
        }
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    empl_id,
                    alw_ch_cnt,
                    SUM(alw_ch_cnt) cnt,
                    eff_date,
                    term_date
                FROM `{$tbl_join}`
                WHERE
                    eff_date <= '{$year}-{$month}-{$lastdate}'
                    AND IF(term_date IS NULL, TRUE, term_date  >= '{$year}-{$month}-{$lastdate}')
                    AND alw_ch_cnt=1 AND active_status=1
                    {$q_empl_id}
                GROUP BY empl_id
                ORDER BY
                    empl_id
            ) ab
            ON r.empl_id = ab.empl_id
            SET
                r.child_cnt = IFNULL(ab.cnt, 0),
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0'
                {$q_empl_id3};
SQL;
//        return <<<SQL
//        UPDATE {$tbl} r
//            INNER JOIN (
//                SELECT
//                    a.tgl_mulai_tunjangan,
//                    a.tgl_akhir_tunjangan,
//                    a.id_pegawai,
//                    b.cnt cnt
//                FROM `{$tbl_join}` a
//                    INNER JOIN (
//                    SELECT
//                        id_pegawai,
//                        count(id_pegawai) cnt,
//                        tgl_mulai_tunjangan,
//                        tgl_akhir_tunjangan
//                    FROM `{$tbl_join}`
//                    WHERE
//                        tgl_mulai_tunjangan <= '{$year}-{$month}-{$lastdate}' AND
//                        tgl_akhir_tunjangan >= '{$year}-{$month}-{$lastdate}'
//                    GROUP BY id_pegawai
//                    ORDER BY
//                        id_pegawai
//                ) b
//                ON
//                    a.id_pegawai=b.id_pegawai
//                    AND
//                    a.tgl_mulai_tunjangan <= '{$year}-{$month}-{$lastdate}'
//                    AND
//                    a.tgl_akhir_tunjangan >= '{$year}-{$month}-{$lastdate}'
//                ORDER BY
//                    a.id_pegawai
//            ) ab
//            ON r.empl_id = ab.id_pegawai
//            SET
//                r.child_cnt = IFNULL(ab.cnt, 0),
//                r.modified = NOW()
//            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
//                AND `lock` = '0';
//SQL;
    }

    # Child Count for Rice Alw

    public static function get_update_alw_rc_ch_cnt($tbl, $tbl_join, $year, $month, $lastdate, $empl_id = null) {
        $q_empl_id  = "";
        $q_empl_id2 = "";
        $q_empl_id3 = "";
        if ($empl_id) {
            $q_empl_id  = "empl_id='{$empl_id}'";
            $q_empl_id2 = "AND a.".$q_empl_id;
            $q_empl_id3 = "AND r.".$q_empl_id;
            $q_empl_id  = "AND ".$q_empl_id;
        }
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    empl_id,
                    alw_rc_ch_cnt,
                    SUM(alw_rc_ch_cnt) cnt,
                    MAX(eff_date) max_eff,
                    term_date
                FROM `{$tbl_join}`
                WHERE
                    eff_date <= '{$year}-{$month}-{$lastdate}'
                    AND IF(term_date IS NULL, TRUE, term_date  >= '{$year}-{$month}-{$lastdate}')
                    AND alw_rc_ch_cnt=1  AND active_status=1
                    {$q_empl_id}
                GROUP BY empl_id
                ORDER BY
                    empl_id
            ) ab
            ON r.empl_id = ab.empl_id
            SET
                r.alw_rc_ch_cnt = IFNULL(ab.cnt, 0),
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0'
                    {$q_empl_id3};
SQL;
    }

    // update NPWP
    public static function get_update_npwp($tbl, $tbl_join, $year, $month, $lastdate, $status=null) {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.npwp,
                    a.reg_date,
                    a.active_status,
                    a.empl_id
                FROM `{$tbl_join}` a
                WHERE
                    '{$year}-{$month}-{$lastdate}' >= a.reg_date
                    AND a.active_status=1
            ) ab
            ON r.empl_id = ab.empl_id
            SET
                r.empl_npwp = ab.npwp,
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

    /**
     * get_update_pph21 tariff
     * @param  [string] $tbl              [table name]
     * @param  [string] $tbl_join         [description]
     * @param  [string] $year             [description]
     * @param  [string] $month            [description]
     * @param  [string] $lastdate         [description]
     * @param  [int] $default_pph21_id  [description]
     * @param  [double] $default_pkp_amt [description]
     * @return [string]                   [description]
     */
    public static function get_update_pph21($tbl, $tbl_join, $year, $month, $lastdate, $default_pph21_id, $default_pkp_amt)
    {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.id,
                    a.pph21_tax,
                    a.eff_date,
                    a.amt_lo,
                    a.amt_hi
                FROM `{$tbl_join}` a
                WHERE
                    a.eff_date <= '{$year}-{$month}-{$lastdate}' AND a.active_status = '1'

            ) ab
            ON (ab.amt_lo AND ab.amt_hi IS NOT NULL) OR (r.tax_base BETWEEN ab.amt_lo AND ab.amt_hi)
            SET
                r.apr_ref_pph21_tariff_id = IFNULL(ab.id,'{$default_pph21_id}'),
                r.pph21_tax = IFNULL(ab.pph21_tax,'{$default_pkp_amt}')
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

public static function get_update_ptkp($tbl, $tbl_join, $year, $month, $lastdate, $default_ptkp_id,$default_ptkp_amt) {
        return <<<SQL
        UPDATE {$tbl} r
            LEFT JOIN (
                SELECT
                    a.id,
                    a.amt,
                    b.child_cnt,
                    IF(b.mar_stat=1,'Menikah', NULL) as ms,
                    a.eff_date
                FROM `{$tbl_join}` a
                    LEFT JOIN (
                    SELECT
                        child_cnt,
                        mar_stat,
                        id
                    FROM `{$tbl_join}_group`
                    WHERE
                        active_status = '1'
                ) b
                ON
                    a.{$tbl_join}_group_id=b.id
                    AND
                        a.eff_date <= '{$year}-{$month}-{$lastdate}'

            ) ab
            ON r.mar_stat = ab.ms AND ab.child_cnt = r.child_cnt
            SET
                r.apr_ref_ptkp_tariff_id = IFNULL(ab.id,'{$default_ptkp_id}'),
                r.ptkp_tariff = IFNULL(ab.amt,'{$default_ptkp_amt}')
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

    /**
     *
     * @param type $tbl
     * @param type $tbl_join r_peg_kontrak | r_peg_capeg | r_peg_tetap
     * @param type $year
     * @param type $month
     * @param type $lastdate
     * @param type $status Kontrak | Capeg | Tetap
     * @return type
     */
    public static function get_update_status($tbl, $tbl_join, $year, $month, $lastdate, $status) {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.sk_tanggal,
                    a.id_pegawai
                FROM `{$tbl_join}` a
                    INNER JOIN (
                    SELECT
                        id_pegawai,
                        count(id_pegawai) cnt,
                        sk_tanggal,
                        max(sk_tanggal) maxsk
                    FROM `{$tbl_join}`
                    WHERE
                        sk_tanggal <= '{$year}-{$month}-{$lastdate}'
                    GROUP BY id_pegawai
                    ORDER BY
                        id_pegawai,
                        sk_tanggal DESC
                ) b
                ON
                    a.id_pegawai=b.id_pegawai
                    AND
                    a.sk_tanggal = b.maxsk
                    AND
                    a.sk_tanggal <= '{$year}-{$month}-{$lastdate}'
                ORDER BY
                    a.id_pegawai,
                    a.sk_tanggal DESC
            ) ab
            ON r.empl_id = ab.id_pegawai
            SET
                r.empl_stat = '{$status}',
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

    public static function get_update_job_unit_title($tbl, $tbl_join, $year, $month, $lastdate) {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.sk_tanggal,
                    a.id_pegawai,
                    a.nama_unor,
                    a.nama_jabatan,
                    a.nomenklatur_pada
                FROM `{$tbl_join}` a
                    INNER JOIN (
                    SELECT
                        id_pegawai,
                        count(id_pegawai) cnt,
                        sk_tanggal,
                        max(sk_tanggal) maxsk
                    FROM `{$tbl_join}`
                    WHERE
                        sk_tanggal <= '{$year}-{$month}-{$lastdate}'
                    GROUP BY id_pegawai
                    ORDER BY
                        id_pegawai,
                        sk_tanggal DESC
                ) b
                ON
                    a.id_pegawai=b.id_pegawai
                    AND
                    a.sk_tanggal = b.maxsk
                    AND
                    a.sk_tanggal <= '{$year}-{$month}-{$lastdate}'
                ORDER BY
                    a.id_pegawai,
                    a.sk_tanggal DESC
            ) ab
            ON r.empl_id = ab.id_pegawai
            SET
                r.job_unit = ab.nama_unor,
                r.job_title = ab.nama_jabatan,
                r.created = NOW(),
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';;
SQL;
    }

    // update Worker Cooperative Member Status
    public static function get_update_wc($tbl, $tbl_join, $year, $month, $lastdate, $status=null) {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.member_since,
                    a.member_term,
                    a.active_status,
                    a.empl_id
                FROM `{$tbl_join}` a
                WHERE
                    '{$year}-{$month}-{$lastdate}' >= a.member_since
                    AND IF (a.member_term IS NULL,
                        TRUE,
                        '{$year}-{$month}-{$lastdate}' < a.member_term
                        )
                        AND a.active_status=1
            ) ab
            ON r.empl_id = ab.empl_id
            SET
                r.empl_wc = 1,
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

    // update Work Day
    public static function get_update_work_day($tbl, $tbl_join, $year, $month, $lastdate, $status=null) {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.print_dt,
                    a.work_day
                FROM `{$tbl_join}` a
                WHERE
                    '{$year}-{$month}-{$lastdate}' = a.print_dt

                        AND a.active_status=1
            ) ab
            ON r.print_dt = ab.print_dt
            SET
                r.work_day = ab.work_day,
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

    // update Dharma Wanita Member Status
    public static function get_update_dw($tbl, $tbl_join, $year, $month, $lastdate, $status=null) {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.member_since,
                    a.member_term,
                    a.active_status,
                    a.empl_id
                FROM `{$tbl_join}` a
                WHERE
                    '{$year}-{$month}-{$lastdate}' >= a.member_since
                    AND IF (a.member_term IS NULL,
                        TRUE,
                        '{$year}-{$month}-{$lastdate}' < a.member_term
                        )
                        AND a.active_status=1
            ) ab
            ON r.empl_id = ab.empl_id
            SET
                r.empl_dw = 1,
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

    // update Worker Cooperative Member Status
    public static function get_update_fkp($tbl, $tbl_join, $year, $month, $lastdate, $status=null) {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.member_since,
                    a.member_term,
                    a.active_status,
                    a.empl_id
                FROM `{$tbl_join}` a
                WHERE
                    '{$year}-{$month}-{$lastdate}' >= a.member_since
                    AND IF (a.member_term IS NULL,
                        TRUE,
                        '{$year}-{$month}-{$lastdate}' < a.member_term
                        )
                        AND a.active_status=1
            ) ab
            ON r.empl_id = ab.empl_id
            SET
                r.empl_fkp = 1,
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

    // update ZAKAT Status
    public static function get_update_zk($tbl, $tbl_join, $year, $month, $lastdate, $status=null) {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.eff_date,
                    a.term_date,
                    a.active_status,
                    a.empl_id
                FROM `{$tbl_join}` a
                WHERE
                    '{$year}-{$month}-{$lastdate}' >= a.eff_date
                    AND IF (a.term_date IS NULL,
                        TRUE,
                        '{$year}-{$month}-{$lastdate}' < a.term_date
                        )
                        AND a.active_status=1
            ) ab
            ON r.empl_id = ab.empl_id
            SET
                r.empl_zk = 1,
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

    // TODO: add documentation
    public function get_update_tax_annual($tbl, $year, $month, $lastdate,  $default)
    {
        return <<<SQL
        UPDATE {$tbl} r
        SET
            `r`.`tax_annual` =
                IF(IFNULL(r.tax_base, 0) > 0,  IFNULL(r.pph21_tax,0) * r.tax_base, 0)
            ,
            r.modified = NOW()
        WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
            AND `lock` = '0';
SQL;
    }


    // TODO: add documentation get_update_tax_comp
    public function get_update_tax_comp($tbl, $tbl_join, $year, $month, $lastdate, $target_field, $menu_code, $base_field)
    {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    IFNULL(a.amt, 0) `amt`,
                    a.amt_max,
                    IF(a.amt_max IS NULL, FALSE, TRUE) `use_max`,
                    a.eff_date,
                    a.menu_code,
                    a.active_status
                FROM `{$tbl_join}` a
                WHERE
                    '{$year}-{$month}-{$lastdate}' >= a.eff_date
                    AND IF (a.term_date IS NULL,
                        TRUE,
                        '{$year}-{$month}-{$lastdate}' < a.term_date
                        )
                        AND a.active_status=1
                        AND a.menu_code= '{$menu_code}'
            ) ab
            ON ab.amt > 0
            SET
                `r`.`{$target_field}` =
                IF(ab.use_max,
                    IF(r.gross_sal * ab.amt > ab.amt_max,
                        ab.amt_max,
                        r.gross_sal * ab.amt
                    ),
                    r.gross_sal * ab.amt
                ),
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

    // TODO: add documentation
    public function get_update_tax_netto($tbl, $year, $month, $lastdate, $target_field)
    {
        return <<<SQL
        UPDATE {$tbl} r
        SET
            `r`.`{$target_field}` =
            r.gross_sal -
            (
                IFNULL(r.tax_ddc_jt,0) +
                IFNULL(r.tax_ddc_jht,0) +
                IFNULL(r.tax_ddc_jp,0)
            ),
            `r`.`tax_base` =
            TRUNCATE(
                (
                    12 * (
                        r.gross_sal -
                        (
                            IFNULL(r.tax_ddc_jt,0) +
                            IFNULL(r.tax_ddc_jht,0) +
                            IFNULL(r.tax_ddc_jp,0)
                        )
                    )
                ),
                -3
            ) - r.ptkp_tariff,
            r.modified = NOW()
        WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
            AND `lock` = '0';
SQL;
    }
    // TODO: add documentation
    // update Water Bill Account Status
    public static function get_update_wb($tbl, $tbl_join, $year, $month, $lastdate, $status=null) {
        return <<<SQL
        UPDATE {$tbl} r
            INNER JOIN (
                SELECT
                    a.acc_reg_date,
                    a.acc_term,
                    a.active_status,
                    a.empl_id
                FROM `{$tbl_join}` a
                WHERE
                    '{$year}-{$month}-{$lastdate}' >= a.acc_reg_date
                    AND IF (a.acc_term IS NULL,
                        TRUE,
                        '{$year}-{$month}-{$lastdate}' < a.acc_term
                        )
                        AND a.active_status=1
            ) ab
            ON r.empl_id = ab.empl_id
            SET
                r.empl_wb = 1,
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}'
                AND `lock` = '0';
SQL;
    }

}
