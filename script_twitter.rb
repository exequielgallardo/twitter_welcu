require 'rubygems'
require 'sqlite3'
require 'twitter_search'

# inicializar o crear bd sqlite
@database = SQLite3::Database.new("twitter.database")
@database.execute("create table if not exists resultados (id INTEGER PRIMARY KEY, usuario TEXT, tweet TEXT, id_busqueda TEXT);")
@database.execute("create table if not exists busqueda (id INTEGER PRIMARY KEY, texto TEXT);")

# busca el tweet si no existe lo insertar a la base de datos
def addTweet(usuario, tweet, id_busqueda)
	found = @database.execute( "select * from resultados where usuario = ? and tweet = ?",
				usuario,
				tweet)
		
	if found.empty? == true then
		@database.execute("insert into resultados (usuario,tweet,id_busqueda) values (
				'#{usuario}',
				'#{tweet}',
				 #{id_busqueda})")
	end
end

#imprimir en pantalla los resultados de la busqueda
def printTweet(usuario, tweet)
  puts "+" * 100
  puts "Usuario: " + usuario
  puts "Tweet: " + tweet  
  puts "+" * 100
  puts " "*100
end


found = @database.execute( "select id,texto from busqueda")
found.each do |texto|
  @navegador = TwitterSearch::Client.new 'Buscador en twitter'
  @tweets = @navegador.query texto[1]
  @tweets.each do |tweet|
   printTweet(tweet.from_user, tweet.text) 
   addTweet(tweet.from_user, tweet.text, texto[0])
  end
end



 



