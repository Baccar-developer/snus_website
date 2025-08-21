<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\products;
use Database\Factories\productsFactory;

class product_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        products::factory(1)->create(["product_name"=>"killa" , "product_image"=>"killa.png" ,"product_desc"=>"KILLA Cold Mint XXL Extra Strong gives you the fresh taste of mint and menthol. Killa Cold Mint are served in slim format portions. This product is served with very high nicotine content. With this Killa product you get the freshness of mint what gives you a super nicotine kick with every pouch. Killa Cold Mint nicopods are created for true nicotine lovers who dares to experiment with flavours and nicotine. The perfect balance between the mint, quality nicotine pouches and high nicotine content makes the this product as a perfect match for everyday use and this time in XXL cans with 30 bags per can. Order Killa Cold Mint at The Royal Snus Online shop!"]);
        products::factory(1)->create(["product_name"=>"velo" , "product_image"=>"velo.png" ,"product_desc"=>""]);
        products::factory(1)->create(["product_name"=>"pablo gold edition" , "product_image"=>"pablo_gold_edition.png","product_desc"=>""]);
        products::factory(1)->create(["product_name"=>"pablo ice cold" , "product_image"=>"pablo_ice_cold.png","product_desc"=>"Pablo Ice Cold XXL Super Strong Slim All White- as Pablo is the good- old, danger strong boy that’s been out there since the very beginning. No one plays games with Pablo. Known for it’s extra high nicotine levels with the fastest nicotine absorption, Pablo has been created for true nicotine lovers with taste of mint. Pablo nicotine pouches are well known worldwide for it's strength, promenent mint flavours and super quality nicopods. With this Pablo product you get the freshness of mint what gives you a super nicotine kick with every pouch. Pablo Ice Cold nicopods are created for true nicotine lovers who dares to experiment with flavours and nicotine. The perfect balance between the mint, quality nicotine pouches and high nicotine content makes the this product as a perfect match for everyday usage. This Pablo product has been served as XXL with 30 nicotine pouches per can what will last much longer. Order Pablo Ice Cold at The Royal Snus Online shop!\nNicotine: extreme high \nNet Weight (g) 16\nIngredients: cellulose, PH-adjustment, humectant, nicotine, aroma, water, preservative.The Pablo nicotine pouches series is manufactured by NGP Empire who has become one of the leading manufacturers with products such as Killa, Pablo and more. PABLO nicotine pouches has been known on market for a while now as Pablo snus, but it doesn't contain any tobacco at all."]);
        
    }
}
