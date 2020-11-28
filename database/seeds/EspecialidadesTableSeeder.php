<?php

use Illuminate\Database\Seeder;

class EspecialidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $especialidades = array(
            array("value" => "Anestesiologia"),
            array("value" => "Cirurgia Plástica"),
            array("value" => "Neurocirurgia"),
            array("value" => "Obstetrícia"),
            array("value" => "Patologia"),
            array("value" => "Tocoginecologia c/ partos"),
            array("value" => "Cirurgia Bucomaxilofacial"),
            array("value" => "Cirurgia de Cabeça e Pescoço"),
            array("value" => "Cirurgia Cardiovascular"),
            array("value" => "Cirurgia Geral"),
            array("value" => "Cirurgia Ginecológica"),
            array("value" => "Cirurgia de Mão"),
            array("value" => "Cirurgia Oftalmológica"),
            array("value" => "Cirurgia Oncológica"),
            array("value" => "Cirurgia Otorrinolaringológica"),
            array("value" => "Cirurgia Pediátrica"),
            array("value" => "Cirurgia Torácica"),
            array("value" => "Cirurgia Vascular Periférica"),
            array("value" => "Clínica Geral ( C/ Partos )"),
            array("value" => "Diagnósticos por Imagens ( C/ Punções )"),
            array("value" => "Gastroenterologia Invasiva"),
            array("value" => "Hemodinâmica"),
            array("value" => "Hemoterapia"),
            array("value" => "Medicina de Emergência"),
            array("value" => "Pneumanologia Invasiva"),
            array("value" => "Proctologia"),
            array("value" => "Urologia"),
            array("value" => "Alergia e Imunologia"),
            array("value" => "Anatomia Patológica"),
            array("value" => "Andrologia"),
            array("value" => "Cardiologia"),
            array("value" => "Clínica Geral"),
            array("value" => "Clínica Médica"),
            array("value" => "Dermatologia"),
            array("value" => "Diagnóstico por Imagens ( S/ Punções )"),
            array("value" => "Endocrinologia"),
            array("value" => "Fisiatria e Reabilitação"),
            array("value" => "Gastroenterologia Clínica"),
            array("value" => "Genética"),
            array("value" => "Ginecologia Clínica"),
            array("value" => "Hematologia"),
            array("value" => "Infectologia"),
            array("value" => "Medicina Nuclear"),
            array("value" => "Nefrologia"),
            array("value" => "Neonatologia"),
            array("value" => "Neurologia"),
            array("value" => "Odontologia com Implantes"),
            array("value" => "Oftalmologia Clínica"),
            array("value" => "Oncologia Clínica"),
            array("value" => "Ortopedia e Traumatologia Clínica"),
            array("value" => "Otorrinolaringologia Clínica"),
            array("value" => "Pediatra"),
            array("value" => "Pneumonologia Clínica"),
            array("value" => "Psiquiatria"),
            array("value" => "Radioterapia"),
            array("value" => "Reumatologia"),
            array("value" => "Terapia Intensiva"),
            array("value" => "Toxicologia"),
            array("value" => "Bioquímica"),
            array("value" => "Cinesiologia"),
            array("value" => "Enfermagem"),
            array("value" => "Especialidades Paramédicas"),
            array("value" => "Farmácia"),
            array("value" => "Fonoaudiologia"),
            array("value" => "Geriatria"),
            array("value" => "Medicina Forense"),
            array("value" => "Medicina Legal"),
            array("value" => "Medicina do Trabalho"),
            array("value" => "Odontologia sem Implantes"),
            array("value" => "Psicologia"),
            array("value" => "Saúde Pública"),
            array("value" => "Médicos Veterinários")
        );

        foreach ($especialidades as $key => $especialidade) {
            DB::table('especiliadades')->insert([
                'descricao' => $especialidade['value'],
            ]);
        }
    }
}
