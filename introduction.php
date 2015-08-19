<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<?php require("html/title.html");?>

		<style type="text/css" href="css/universal.css" ></style>
		<style type="text/css">
			div { 
				margin: 10px;
				padding: 10px; 
				
			}
			p { 
				margin: 3px;
			}
			.centered {
				text-align: center;
			}
			.bordered {
				border: 2px solid;
			}
			.percent50 {
				width: 50%;
			}
			.floatLeft {
				float: left;
				overflow:hidden;
			}
			.floatRight {
				overflow:hidden;
			}
			.height300px {
				height: 300px;
			}
		</style>
	</head>
	<body>

		<p> Hello! Welcome to the Chemical Genomics Manual. </p>
		<div id="quick_ref" class="height300px percent50 floatLeft"><div class=""><b> Quick Reference </b></div>
			<p> Username: chemical_genomics </p>
			<p> Password: chemgenweb </p>
			<p> <a href="http://lovelace-umh.cs.umn.edu/chemical_genomics/"> Chemical Genomics Website </a> </p>
			<p> <a href="http://lovelace-umh.cs.umn.edu/chemical_genomics_dev/chemical_property_browser.php"> Chemical Property Browser </a> </p>
			<p> <a href="http://lovelace-umh.cs.umn.edu/chemical_genomics_misc/individualClustergrams_latest/drugGram_latest.tar.gz">  Druggrams </a> </p>
			<p> <a href="http://lovelace-umh.cs.umn.edu/chemical_genomics_misc/individualClustergrams_latest/superdruggram.tar.gz"> Super Druggrams</a> </p>
			<p> <a href="http://lovelace-umh.cs.umn.edu/chemical_genomics_misc//multiple_targets/2014-04-24_multiple-targets_RIKEN-fdr25_cutoff-0.5_glob.txt"> Multiple Target Prediction </a></p>
		</div>
		<div id="table_of_contents" class="bordered height300px"><div class=""><b> Table of Contents </b></div>
			<p> <a href="#website"> Chemical Genomics Website </a> </p>
			<p> <a href="#property_browser"> Chemical Property Browser </a> </p>
			<p> <a href="#druggrams">  Druggrams </a> </p>
			<p> <a href="#multiple_targets"> Multiple Target Prediction </a> </p>
		</div>
		<div id="website"> <div class="centered"><b> The Chemical Genomics Website </b></div>
			<div id="ws_location"> <b> Location </b>
				<p> The chemical genomics website is found <a href=http://lovelace-umh.cs.umn.edu/chemical_genomics/> here</a>. </p>
				<p> The username for the website is: <b>chemical_genomics</b> </p>
				<p> The password for the website is: <b>chemgenweb</b> </p>
			</div>
			<div id="ws_chemicalQuery"> <b> Chemical Query </b>
				<p>Chemicals can be queried by entering their name into the <b>query box</b> and hitting the <b>search button</b>, or enter.</p>
				<p>A list of chemicals which match the query will show up in the top section. On the left is a picture of the chemicals structure. On the right is a table that can be interacted with. It will contain the name of the chemical, the multiplex tag, the sequencing lane, and the replicate information associated with the chemical.</p>
				<p>For most applications, only the chemical name matters since we have combined different replicates. The only thing that changes between different multiplex tags is the content of the <b>SCATTER tab</b>. </p>
				<p>An example query for this type of search is:</p><p>Benomyl</p>
			</div>
			<div id="ws_targetQuery"> <b> Target Query </b>
				<p>Direct Gene Targets can be queried by entering their name into the <b>query box</b> and hitting the <b>search button</b>, or enter.</p>
				<p>A list of Gene Targets which match the query will show up in the top section.</p>
				<p>Since you are searching for a gene target, the only appropriate result that makes sense is the <b>Gene-level Target Predictions</b>. </p>
				<p>An example query for this type of search is:</p><p>TUB3</p>
			</div>
			<div id="ws_GOQuery"> <b> GO Query </b>
				<p>GO names or GO IDs can be queried by entering their name into the <b>query box</b> and hitting the <b>search button</b>, or enter.</p>
				<p>A list of GO names and GO Ids which match the query will show up in the top section.</p>
				<p>Since you are searching for a process, the only appropriate result table that makes sense is the <b>Process-level Target Predictions</b>. </p>
				<p>Example queries for this type of search are:</p><p>tubulin complex assembly</p><p>GO:0007021</p>
			</div>
			<div id="ws_multiQuery"> <b> Multi Query </b>
				<p> Another feature of the website is the ability to search multiple chemicals, targets or GO terms at the same time. You can search multiple things at once by seperating your query items by semicolons (;).</p>
				<p> A couple of examples for this type of search are: </p><p>Benomyl; Nocodazole</p><p>tubulin complex assembly; microtubule-based process</p><p>Benomyl; TUB3; tubulin complex assembly</p>
			</div>
			<div id="ws_results"> <b> Results </b>
				<div id="ws_results_proc"> <b> Process-level Target Predictions </b> 
					<p> Process-level Target predictions are the GO processes that were found to be enriched in gene-level target predictions that belong to a certain GO term. </p>
				</div>
				<div id="ws_results_gene"> <b> Gene-level Target Predictions </b> 
					<p> Gene-level Target predictions are the genes that are similar in genetic interactions profile to the chemical genetic profile.</p>
				</div>
				<div id="ws_results_CGP"> <b> Chemical Genetic Profile </b> 
					<p> Chemical Genetic Profile is the scores for the chemical genetic profile </p>
				</div>
				<div id="ws_results_chemSim"> <b> ChemSIM </b> 
					<p> Chemical Similarity is the similarity in the chemical structure of a chemical with all other chemicals. </p>
				</div>
				<div id="ws_results_profSim"> <b> ProfSIM </b> 
					<p> Profile Similarity is the similarity between chemical genetic profiles of a chemical with all other chemicals. </p>
				</div>
				<div id="ws_results_scatter"> <b> SCATTER </b> 
					<p> Scatterplots are the comparison of the condition of interest with DMSO at various levels of the chemical genetic profile scoring pipeline </p> 
				</div>
			</div>
		</div>
		<div id="property_browser"> <div class="centered"><b> Chemical Property Browser </b></div>
			<div id="pb_location"> <b> Location </b>
				<p> The chemical property browser is found <a href="http://lovelace-umh.cs.umn.edu/chemical_genomics_dev/chemical_property_browser.php"> here</a>. </p>
				<p> The username for the website is: <b>chemical_genomics</b> </p>
				<p> The password for the website is: <b>chemgenweb</b> </p>
			</div>
			<div id="pb_explaination"><b> Property Browser </b>
				<p> The chemical property browser is a way to batch query chemicals to get their structure, bioactivity, or top predictions.</p>
				<p> You can search by a semicolon (;) delimited list or by having one drug per line. The search box is optimized to be able to take (copy-paste) input from other programs such as excel. </p>
			</div>
		</div>
		<div id="druggrams"> <div class="centered"><b> The Druggram Visualizations </b></div>
			<div id="dg_location"> <b> Location </b>
				<p> The drugGrams can be downloaded in tarball form <a href=http://lovelace-umh.cs.umn.edu/chemical_genomics_misc/individualClustergrams_latest/drugGram_latest.tar.gz> here</a>. </p>
				<p> The super_drugGrams can be downloaded in tarball form <a href=http://lovelace-umh.cs.umn.edu/chemical_genomics_misc/individualClustergrams_latest/superdruggram.tar.gz> here</a>. </p>			
			</div> 
			<div id="dg_regular"> <b> Druggrams </b>
				<p> The druggrams are a visualization of which genes on the array are causing process predictions. Each druggram is structured as follows: </p>

				<p>The rows of the druggram are the array genes, clustered as they would be clustered in the genetic interaction clustergram.</p>

				<p>The first column of the druggram is the chemical genetic profile. <br>
				The next columns of the druggram are the relative contribution of each array gene to process predictions. Rows that are green are contributing FOR that columns process prediction. Rows that are red are contributing AGAINST that columns process prediction. <br>
				After the process predictions is a repeat of the chemical genetic profile. <br>
				The rest of the druggram are the genes from the genetic interaction network which participate in at least one FDR25 process prediction.</p>
			</div> 
			<div id="dg_super"> <b> Super Druggrams </b>
				<p> While the druggrams are for each drug, the super druggram is all of the process columns of the druggrams put together.</p>
				<p> There are two super druggrams: the full super druggram and the drug super druggram.<br>
				The full superdruggram has every drug, process combination that was found in the FDR25 set, and the array genes that contribute to that enrichment.<br>
				The drug super druggram has every drug that was found in the FDR25 Set, and the array genes that are important for that drug's enrichments</p>
			</div> 
		</div>
		<div id="multiple_targets"> <div class="centered"><b> Drugs Targeting Multiple Processes </b></div>
			<div id="mt_location"> <b> Location </b>
				<p> The multiple target predictions are found <a href=http://lovelace-umh.cs.umn.edu/chemical_genomics_misc//multiple_targets/2014-04-24_multiple-targets_RIKEN-fdr25_cutoff-0.5_glob.txt> here</a>. </p>
			</div> 
			<div id="mt_predictions"> <b> Multiple Process Predictions </b>
				<p> The list is first sorted by drug, with those most likely to target multiple biological processes at the top. </p>

				<p> The processes targeted by each drug are then split into groups, each of which is driven by a unique set of strains in the minipool (a process driver profile). <br>
 				We look for the greatest dissimilarity between each drug's process driver profiles and say the probability that a drug targets multiple processes increases as that dissimilarity increases. </p>

				<p> These results are nicely visualized using the individiual druggrams. </p>
			</div> 
		</div>
	</body>
</html>
