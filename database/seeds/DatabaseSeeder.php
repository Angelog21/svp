<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\Person;
use App\Office;
use App\Area;
use App\Holiday;
use App\Period;
use App\Direction;
use App\Reason;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Role::class, 1)->create(['name'=>'Root']);
        factory(Role::class, 1)->create(['name'=>'Superadmin']);
        factory(Role::class, 1)->create(['name'=>'DirectorG']);
        factory(Role::class, 1)->create(['name'=>'DirectorL']);
        factory(Role::class, 1)->create(['name'=>'Supervisor']);
        factory(Role::class, 1)->create(['name'=>'AnalistaVacaciones']);
        factory(Role::class, 1)->create(['name'=>'AnalistaPermisos']);
        factory(Role::class, 1)->create(['name'=>'Empleado']);

        factory(Office::class,1)->create(['name'=>'Ninguno','acronimo'=>'Ninguno']);
        factory(Direction::class,1)->create(['office_id'=>1,'name'=>'Ninguno']);
        factory(Area::class,1)->create(['direction_id'=>1,'name'=>'Ninguno']);

        factory(Person::class, 1)->create(['name'=>'root', 'card_id'=>'12345678', 'extension'=>'1234','phone'=>'04261234567','date_admission'=>'2019-04-12'])
        ->each(function (Person $p){
            factory(User::class,1)->create(['person_id'=>$p->id,'username'=>'root','email'=>'root@gmail.com','password'=>bcrypt('123456'),'role_id'=>Role::ROOT,'state'=>User::AVAILABLE]);
        });
        factory(Office::class,1)->create(['name'=>'Oficina de Tecnologia informacion y comunicacion','acronimo'=>'OTIC'])
        ->each(function(Office $o){
            factory(Direction::class,1)->create(['office_id'=>$o->id,'name'=>'Direccion de Gestion de innovacion tecnologica']);
            factory(Direction::class,1)->create(['office_id'=>$o->id,'name'=>'Direccion de Gestion de la plataforma tecnologica']);

            factory(Area::class,1)->create(['direction_id'=>2,'name'=>'Automatizacion de procesos']);
            factory(Area::class,1)->create(['direction_id'=>2,'name'=>'Telematica']);
            factory(Area::class,1)->create(['direction_id'=>2,'name'=>'proyectos']);

            factory(Area::class,1)->create(['direction_id'=>3,'name'=>'Atencion tecnologica']);
            factory(Area::class,1)->create(['direction_id'=>3,'name'=>'Seguridad informatica']);
            factory(Area::class,1)->create(['direction_id'=>3,'name'=>'infraestructura']);

            factory(Person::class, 1)->create(['name'=>'Carlos Berbeci', 'card_id'=>'12345679', 'extension'=>'1234','phone'=>'04261234567','date_admission'=>'2010-03-12'])
            ->each(function (Person $p){
                factory(User::class,1)->create(['person_id'=>$p->id,'area_id'=>1,'direction_id'=>1,'office_id'=>2,'username'=>'carlos21','email'=>'carlos@gmail.com','password'=>bcrypt('123456'),'role_id'=>Role::DIRECTOR_GENERAL,'state'=>User::AVAILABLE]);
            });

            //usuario DL
            factory(Person::class, 1)->create(['name'=>'Jose perez', 'card_id'=>'87654321', 'extension'=>'1234','phone'=>'04261234567','date_admission'=>'2010-03-12'])
            ->each(function (Person $p){
                factory(User::class,1)->create(['person_id'=>$p->id,'area_id'=>1,'direction_id'=>2,'office_id'=>2,'username'=>'jose21','email'=>'jose@gmail.com','password'=>bcrypt('123456'),'role_id'=>Role::DIRECTOR_LINEA,'state'=>User::AVAILABLE]);
            });

            factory(Person::class, 1)->create(['name'=>'Carmen Ruiz', 'card_id'=>'1234987', 'extension'=>'1234','phone'=>'04261234567','date_admission'=>'2010-03-12'])
            ->each(function (Person $p){
                factory(User::class,1)->create(['person_id'=>$p->id,'area_id'=>2,'direction_id'=>2,'office_id'=>2,'username'=>'carmen21','email'=>'carmen@gmail.com','password'=>bcrypt('123456'),'role_id'=>Role::SUPERVISOR,'state'=>User::AVAILABLE]);
            });

            factory(Person::class,1)->create(['name'=>'alexey rojas', 'card_id'=>'27472963', 'extension'=>'1234','phone'=>'04261234567','date_admission'=>'2010-11-28'])
            ->each(function(Person $p){
                factory(User::class)->create(['person_id'=>$p->id,'area_id'=>2,'direction_id'=>2,'office_id'=>2,'username'=>'alexey21','email'=>'alexey@gmail.com','password'=>bcrypt('123456'),'role_id'=>Role::EMPLEADO,'state'=>User::AVAILABLE]);
            });

        });
        //factorizacion oficina de gestion humana
        factory(Office::class,1)->create(['name'=>'Oficina de Gestion Humana','acronimo'=>'OGH']);
        factory(Direction::class,1)->create(['office_id'=>3,'name'=>'Direccion de politica laboral']);
        factory(Area::class,1)->create(['direction_id'=>4,'name'=>'administracion de personal']);

        factory(Person::class, 1)->create(['name'=>'Maria Teresa', 'card_id'=>'27624967', 'extension'=>'1234','phone'=>'04261234567','date_admission'=>'2010-03-12'])
            ->each(function (Person $p){
                factory(User::class,1)->create(['person_id'=>$p->id,'area_id'=>1,'direction_id'=>1,'office_id'=>3,'username'=>'maria12','email'=>'maria@gmail.com','password'=>bcrypt('123456'),'role_id'=>Role::SUPERADMIN,'state'=>User::AVAILABLE]);
            });

        factory(Person::class, 1)->create(['name'=>'Jonny Rojas', 'card_id'=>'13087123', 'extension'=>'1234','phone'=>'04261234567','date_admission'=>'2015-08-25'])
        ->each(function (Person $p){
            factory(User::class,1)->create(['person_id'=>$p->id,'area_id'=>8,'direction_id'=>4,'office_id'=>3,'username'=>'jonny21','email'=>'jonny@gmail.com','password'=>bcrypt('123456'),'role_id'=>Role::SUPERVISOR,'state'=>User::AVAILABLE]);
        });

        factory(Person::class, 1)->create(['name'=>'Yoleni Marquez', 'card_id'=>'28794562', 'extension'=>'1234','phone'=>'04261234567','date_admission'=>'2010-08-15'])
        ->each(function (Person $p){
            factory(User::class,1)->create(['person_id'=>$p->id,'area_id'=>8,'direction_id'=>4,'office_id'=>3,'username'=>'yoleni21','email'=>'yoleni@gmail.com','password'=>bcrypt('123456'),'role_id'=>Role::ANALISTA_VACACIONES,'state'=>User::AVAILABLE]);
        });

        factory(Person::class, 1)->create(['name'=>'Maritza Flores', 'card_id'=>'6267343', 'extension'=>'1234','phone'=>'04261234567','date_admission'=>'2010-08-15'])
        ->each(function (Person $p){
            factory(User::class,1)->create(['person_id'=>$p->id,'area_id'=>8,'direction_id'=>4,'office_id'=>3,'username'=>'maritza21','email'=>'maritza@gmail.com','password'=>bcrypt('123456'),'role_id'=>Role::ANALISTA_PERMISOS,'state'=>User::AVAILABLE]);
        });

        factory(Period::class,5)->create(['user_id'=>5]);
        factory(Holiday::class,10)->create(['applicant_id'=>5]);
        factory(Reason::class,10)->create();
    }
}
