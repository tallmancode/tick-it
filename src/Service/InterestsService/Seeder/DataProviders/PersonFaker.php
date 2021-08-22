<?php


namespace App\Service\InterestsService\Seeder\DataProviders;


class PersonFaker extends Base
{
    protected static $firstName = [
        'Abraham', 'Adriaan', 'Adrian', 'Ahmed', 'Alan', 'Amanda', 'Andiswa', 'Andrea', 'Bruce', 'Bryan', 'Carel', 'Carl', 'Charl',
        'Deborah', 'Denise', 'Desiree', 'Diane', 'Dimakatso', 'Dineo', 'Nicholas', 'Nick', 'Nico', 'Nigel', 'Nkululeko', 'Norman', 'Ntokozo',
        'Refilwe', 'Robin', 'Robyn', 'Ronel', 'Roxanne', 'Andries', 'Babalwa', 'Barend', 'Bulelwa', 'Contact ', 'Dumisani', 'Fikile', 'Jacobus', 'Kabelo', 'Kagiso', 'Karabo', 'Kelebogile', 'Lesego',
        'Lindiwe', 'Marthinus', 'Mashudu', 'Next', 'Nhlanhla', 'Nicolaas', 'Nkosinathi', 'Nompumelelo', 'Nonhlanhla', 'Nonkululeko', 'Nosipho', 'Nozipho',
        'Personal', 'Phumzile', 'Refiloe', 'Sello', 'Sibongile', 'Sifiso', 'Siphokazi', 'Takalani', 'Teboho', 'Thandeka', 'Thandi', 'Thembi',
        'Thulani', 'Tumelo', 'Unathi', 'Vusi', 'Vuyokazi', 'Yolandi', 'Cyril', 'Zandile',
    ];

    protected static $lastName = [
        'Naidoo', 'Govender', 'Pillay', 'Smith', 'Botha', 'van der Merwe', 'Jacobs', 'Moodley', 'Singh', 'Ndlovu', 'Dlamini',
        'Pretorius', 'Williams', 'Khumalo', 'du Plessis', 'Nkosi', 'Coetzee', 'Venter', 'Nel', 'Fourie', 'Van Wyk', 'Chetty',
        'Smit', 'Kruger', 'Van Zyl', 'Sithole', 'du Toit', 'Adams', 'van Niekerk', 'Reddy', 'Khan', 'Meyer', 'Mahlangu', 'Abrahams',
        'Mokoena', 'Erasmus', 'Dube', 'Louw', 'Le Roux', 'Steyn', 'Tshabalala', 'Swanepoel', 'Naicker', 'Marais', 'Joubert',
        'Baloyi', 'Petersen', 'Davids', 'Viljoen', 'Maharaj', 'Details', 'Swart', 'Radebe', 'Potgieter', 'van der Westhuizen',
        'Move', 'Strydom', 'Mkhize', 'Olivier', 'Du Preez', 'Van Rooyen', 'Brown', 'Engelbrecht', 'Oosthuizen', 'Hendricks',
        'Ngwenya', 'van der Walt', 'Johnson', 'Thomas', 'Van Heerden', 'Ngcobo', 'de Beer', 'Khoza', 'Barnard', 'Ferreira',
        'Muller', 'Mazibuko', 'Zulu', 'Moyo', 'Zwane', 'Maseko', 'Chauke', 'Bezuidenhout', 'De Villiers', 'Jones', 'Buthelezi',
        'Mthembu', 'Jordaan', 'Molefe', 'Mofokeng', 'Burger', 'Visser', 'Daniels', 'Maluleke', 'Pienaar', 'Martin', 'Cloete',
        'Prinsloo', 'Mathebula', 'Janse van Rensburg', 'Grobler', 'Wilson', 'Ncube', 'Gumede', 'Ngobeni', 'Moloi', 'Kekana',
        'Mhlongo', 'Mbatha', 'Nxumalo', 'Theron', 'Snyman', 'Phiri', 'Sibiya', 'Ntuli', 'Van Den Berg', 'Mabaso', 'Bester',
        'Isaacs', 'Labuschagne', 'Jansen', 'Pieterse', 'Vorster', 'De Wet', 'Schoeman', 'De Klerk', 'Groenewald', 'Sibanda',
        'Rossouw', 'Van Rensburg', 'Naidu', 'De Jager', 'van Staden', 'Scheepers', 'Nhlapo', 'Nkuna', 'Kotze', 'Mtshali',
        'Modise', 'Ismail', 'Van Schalkwyk', 'Padayachee', 'Taylor', 'Thompson', 'Motaung', 'Booysen', 'Patel', 'Harris',
        'Joseph', 'Mthethwa', 'Arendse', 'Vilakazi', 'Lombard', 'Roberts', 'Steenkamp', 'Roux', 'Gouws', 'Botes', 'De Kock',
        'Lewis', 'James', 'Mnisi', 'Mohamed', 'Africa', 'Wessels', 'Badenhorst', 'Miller', 'Hlongwane', 'Hlatshwayo', 'Vermeulen',
        'Kunene', 'Liebenberg', 'Alexander', 'Mudau', 'Myburgh', 'van Tonder', 'Hattingh', 'Mhlanga', 'Francis', 'Mkhwanazi',
        'Basson', 'Boshoff', 'Scott', 'Xaba', 'De Lange', 'Mphahlele', 'Ebrahim', 'Cele', 'Matlala', 'Beukes', 'Coetzer',
        'Nkomo', 'Ledwaba', 'Ndaba', 'Parker', 'Els', 'Green', 'Mnguni', 'Scholtz', 'King', 'Anderson', 'Langa', 'Mulaudzi',
    ];

    public function firstName(): string
    {
         return self::randomElement(self::$firstName);
    }
    public function lastName(): string
    {
        return self::randomElement(self::$lastName);

    }
}