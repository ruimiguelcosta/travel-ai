<?php

namespace App\Domain\Chat\Services;

class LanguageDetectionService
{
    private array $languagePatterns = [
        'pt' => [
            'words' => ['o', 'a', 'os', 'as', 'um', 'uma', 'de', 'da', 'do', 'das', 'dos', 'em', 'na', 'no', 'nas', 'nos', 'para', 'com', 'por', 'sobre', 'entre', 'através', 'durante', 'após', 'antes', 'depois', 'quando', 'onde', 'como', 'porque', 'que', 'quem', 'qual', 'quais', 'cujo', 'cuja', 'cujos', 'cujas', 'meu', 'minha', 'meus', 'minhas', 'teu', 'tua', 'teus', 'tuas', 'seu', 'sua', 'seus', 'suas', 'nosso', 'nossa', 'nossos', 'nossas', 'este', 'esta', 'estes', 'estas', 'esse', 'essa', 'esses', 'essas', 'aquele', 'aquela', 'aqueles', 'aquelas', 'sim', 'não', 'talvez', 'talvez', 'obrigado', 'obrigada', 'por favor', 'desculpe', 'com licença', 'bom dia', 'boa tarde', 'boa noite', 'olá', 'oi', 'tchau', 'até logo', 'até breve', 'até amanhã', 'hoje', 'ontem', 'amanhã', 'agora', 'depois', 'antes', 'sempre', 'nunca', 'às vezes', 'frequentemente', 'raramente', 'muito', 'pouco', 'bastante', 'demais', 'mais', 'menos', 'muito', 'pouco', 'bastante', 'demais', 'mais', 'menos', 'grande', 'pequeno', 'alto', 'baixo', 'longo', 'curto', 'largo', 'estreito', 'grosso', 'fino', 'pesado', 'leve', 'rápido', 'lento', 'fácil', 'difícil', 'simples', 'complexo', 'novo', 'velho', 'jovem', 'antigo', 'moderno', 'tradicional', 'bonito', 'feio', 'bom', 'mau', 'melhor', 'pior', 'ótimo', 'terrível', 'excelente', 'horrível', 'perfeito', 'imperfeito', 'completo', 'incompleto', 'cheio', 'vazio', 'aberto', 'fechado', 'quente', 'frio', 'morno', 'fresco', 'seco', 'molhado', 'limpo', 'sujo', 'organizado', 'desorganizado', 'arrumado', 'bagunçado', 'calmo', 'agitado', 'tranquilo', 'barulhento', 'silencioso', 'alto', 'baixo', 'forte', 'fraco', 'duro', 'mole', 'rígido', 'flexível', 'sólido', 'líquido', 'gasoso', 'quente', 'frio', 'morno', 'fresco', 'seco', 'molhado', 'limpo', 'sujo', 'organizado', 'desorganizado', 'arrumado', 'bagunçado', 'calmo', 'agitado', 'tranquilo', 'barulhento', 'silencioso', 'alto', 'baixo', 'forte', 'fraco', 'duro', 'mole', 'rígido', 'flexível', 'sólido', 'líquido', 'gasoso'],
            'phrases' => ['como está', 'tudo bem', 'como vai', 'está tudo', 'muito obrigado', 'obrigado pela', 'por favor', 'desculpe-me', 'com licença', 'bom dia', 'boa tarde', 'boa noite', 'até logo', 'até breve', 'até amanhã', 'que horas', 'que dia', 'que mês', 'que ano', 'onde fica', 'como chegar', 'quanto custa', 'quanto é', 'quanto vale', 'quanto tempo', 'há quanto tempo', 'faz quanto tempo', 'desde quando', 'até quando', 'por quanto tempo', 'durante quanto tempo', 'quando foi', 'quando vai', 'quando aconteceu', 'quando vai acontecer', 'onde está', 'onde fica', 'onde fica', 'onde posso', 'onde consigo', 'onde encontro', 'onde acho', 'onde compro', 'onde vendo', 'onde alugo', 'onde reservo', 'onde faço', 'onde posso fazer', 'onde consigo fazer', 'onde encontro', 'onde acho', 'onde compro', 'onde vendo', 'onde alugo', 'onde reservo', 'onde faço', 'onde posso fazer', 'onde consigo fazer'],
        ],
        'en' => [
            'words' => ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by', 'from', 'up', 'about', 'into', 'through', 'during', 'before', 'after', 'above', 'below', 'between', 'among', 'under', 'over', 'around', 'near', 'far', 'here', 'there', 'where', 'when', 'why', 'how', 'what', 'who', 'which', 'whose', 'whom', 'this', 'that', 'these', 'those', 'i', 'you', 'he', 'she', 'it', 'we', 'they', 'me', 'him', 'her', 'us', 'them', 'my', 'your', 'his', 'her', 'its', 'our', 'their', 'mine', 'yours', 'hers', 'ours', 'theirs', 'myself', 'yourself', 'himself', 'herself', 'itself', 'ourselves', 'yourselves', 'themselves', 'yes', 'no', 'maybe', 'perhaps', 'thank you', 'thanks', 'please', 'sorry', 'excuse me', 'hello', 'hi', 'goodbye', 'bye', 'see you', 'see you later', 'see you tomorrow', 'today', 'yesterday', 'tomorrow', 'now', 'then', 'before', 'after', 'always', 'never', 'sometimes', 'often', 'rarely', 'very', 'quite', 'rather', 'too', 'so', 'such', 'much', 'many', 'little', 'few', 'more', 'less', 'most', 'least', 'big', 'small', 'large', 'tiny', 'huge', 'enormous', 'giant', 'miniature', 'tall', 'short', 'long', 'brief', 'wide', 'narrow', 'thick', 'thin', 'heavy', 'light', 'fast', 'slow', 'quick', 'rapid', 'easy', 'hard', 'difficult', 'simple', 'complex', 'new', 'old', 'young', 'ancient', 'modern', 'traditional', 'beautiful', 'ugly', 'pretty', 'handsome', 'good', 'bad', 'better', 'worse', 'best', 'worst', 'excellent', 'terrible', 'perfect', 'awful', 'great', 'wonderful', 'amazing', 'fantastic', 'incredible', 'awesome', 'brilliant', 'outstanding', 'superb', 'magnificent', 'gorgeous', 'stunning', 'breathtaking', 'spectacular', 'marvelous', 'fabulous', 'splendid', 'glorious', 'divine', 'heavenly', 'perfect', 'flawless', 'impeccable', 'faultless', 'complete', 'incomplete', 'full', 'empty', 'open', 'closed', 'hot', 'cold', 'warm', 'cool', 'dry', 'wet', 'clean', 'dirty', 'organized', 'disorganized', 'tidy', 'messy', 'calm', 'excited', 'peaceful', 'noisy', 'quiet', 'loud', 'soft', 'strong', 'weak', 'hard', 'soft', 'rigid', 'flexible', 'solid', 'liquid', 'gas', 'hot', 'cold', 'warm', 'cool', 'dry', 'wet', 'clean', 'dirty', 'organized', 'disorganized', 'tidy', 'messy', 'calm', 'excited', 'peaceful', 'noisy', 'quiet', 'loud', 'soft', 'strong', 'weak', 'hard', 'soft', 'rigid', 'flexible', 'solid', 'liquid', 'gas'],
            'phrases' => ['how are you', 'how is it going', 'how do you do', 'what\'s up', 'what\'s new', 'what\'s happening', 'how\'s everything', 'how\'s life', 'how\'s work', 'how\'s school', 'how\'s family', 'how\'s health', 'how\'s weather', 'how\'s day', 'how\'s week', 'how\'s month', 'how\'s year', 'how\'s vacation', 'how\'s holiday', 'how\'s weekend', 'how\'s evening', 'how\'s morning', 'how\'s afternoon', 'how\'s night', 'how\'s sleep', 'how\'s rest', 'how\'s break', 'how\'s pause', 'how\'s stop', 'how\'s end', 'how\'s finish', 'how\'s complete', 'how\'s done', 'how\'s ready', 'how\'s prepared', 'how\'s set', 'how\'s ready', 'how\'s prepared', 'how\'s set', 'how\'s ready', 'how\'s prepared', 'how\'s set'],
        ],
        'es' => [
            'words' => ['el', 'la', 'los', 'las', 'un', 'una', 'unos', 'unas', 'de', 'del', 'de la', 'de los', 'de las', 'en', 'en el', 'en la', 'en los', 'en las', 'para', 'con', 'por', 'sobre', 'entre', 'durante', 'después', 'antes', 'cuando', 'donde', 'como', 'porque', 'que', 'quien', 'cual', 'cuales', 'cuyo', 'cuya', 'cuyos', 'cuyas', 'mi', 'mis', 'tu', 'tus', 'su', 'sus', 'nuestro', 'nuestra', 'nuestros', 'nuestras', 'este', 'esta', 'estos', 'estas', 'ese', 'esa', 'esos', 'esas', 'aquel', 'aquella', 'aquellos', 'aquellas', 'sí', 'no', 'tal vez', 'quizás', 'gracias', 'por favor', 'disculpe', 'perdón', 'buenos días', 'buenas tardes', 'buenas noches', 'hola', 'adiós', 'hasta luego', 'hasta pronto', 'hasta mañana', 'hoy', 'ayer', 'mañana', 'ahora', 'después', 'antes', 'siempre', 'nunca', 'a veces', 'frecuentemente', 'raramente', 'muy', 'poco', 'bastante', 'demasiado', 'más', 'menos', 'mucho', 'poco', 'bastante', 'demasiado', 'más', 'menos', 'grande', 'pequeño', 'alto', 'bajo', 'largo', 'corto', 'ancho', 'estrecho', 'grueso', 'fino', 'pesado', 'ligero', 'rápido', 'lento', 'fácil', 'difícil', 'simple', 'complejo', 'nuevo', 'viejo', 'joven', 'antiguo', 'moderno', 'tradicional', 'bonito', 'feo', 'bueno', 'malo', 'mejor', 'peor', 'excelente', 'terrible', 'perfecto', 'imperfecto', 'completo', 'incompleto', 'lleno', 'vacío', 'abierto', 'cerrado', 'caliente', 'frío', 'tibio', 'fresco', 'seco', 'húmedo', 'limpio', 'sucio', 'organizado', 'desorganizado', 'ordenado', 'desordenado', 'tranquilo', 'agitado', 'pacífico', 'ruidoso', 'silencioso', 'alto', 'bajo', 'fuerte', 'débil', 'duro', 'blando', 'rígido', 'flexible', 'sólido', 'líquido', 'gaseoso', 'caliente', 'frío', 'tibio', 'fresco', 'seco', 'húmedo', 'limpio', 'sucio', 'organizado', 'desorganizado', 'ordenado', 'desordenado', 'tranquilo', 'agitado', 'pacífico', 'ruidoso', 'silencioso', 'alto', 'bajo', 'fuerte', 'débil', 'duro', 'blando', 'rígido', 'flexible', 'sólido', 'líquido', 'gaseoso'],
            'phrases' => ['¿cómo está', '¿cómo va', '¿cómo le va', '¿cómo está todo', 'muchas gracias', 'gracias por', 'por favor', 'disculpe', 'con permiso', 'buenos días', 'buenas tardes', 'buenas noches', 'hasta luego', 'hasta pronto', 'hasta mañana', '¿qué hora', '¿qué día', '¿qué mes', '¿qué año', '¿dónde queda', '¿cómo llegar', '¿cuánto cuesta', '¿cuánto es', '¿cuánto vale', '¿cuánto tiempo', '¿hace cuánto tiempo', '¿desde cuándo', '¿hasta cuándo', '¿por cuánto tiempo', '¿durante cuánto tiempo', '¿cuándo fue', '¿cuándo va', '¿cuándo pasó', '¿cuándo va a pasar', '¿dónde está', '¿dónde queda', '¿dónde puedo', '¿dónde consigo', '¿dónde encuentro', '¿dónde compro', '¿dónde vendo', '¿dónde alquilo', '¿dónde reservo', '¿dónde hago', '¿dónde puedo hacer', '¿dónde consigo hacer', '¿dónde encuentro', '¿dónde compro', '¿dónde vendo', '¿dónde alquilo', '¿dónde reservo', '¿dónde hago', '¿dónde puedo hacer', '¿dónde consigo hacer'],
        ],
        'fr' => [
            'words' => ['le', 'la', 'les', 'un', 'une', 'des', 'de', 'du', 'de la', 'des', 'en', 'dans', 'sur', 'sous', 'pour', 'avec', 'par', 'entre', 'pendant', 'après', 'avant', 'quand', 'où', 'comment', 'pourquoi', 'que', 'qui', 'quel', 'quels', 'quelle', 'quelles', 'dont', 'mon', 'ma', 'mes', 'ton', 'ta', 'tes', 'son', 'sa', 'ses', 'notre', 'nos', 'votre', 'vos', 'leur', 'leurs', 'ce', 'cet', 'cette', 'ces', 'oui', 'non', 'peut-être', 'merci', 's\'il vous plaît', 'excusez-moi', 'pardon', 'bonjour', 'bonsoir', 'bonne nuit', 'salut', 'au revoir', 'à bientôt', 'à demain', 'aujourd\'hui', 'hier', 'demain', 'maintenant', 'après', 'avant', 'toujours', 'jamais', 'parfois', 'souvent', 'rarement', 'très', 'peu', 'assez', 'trop', 'plus', 'moins', 'beaucoup', 'peu', 'assez', 'trop', 'plus', 'moins', 'grand', 'petit', 'haut', 'bas', 'long', 'court', 'large', 'étroit', 'épais', 'fin', 'lourd', 'léger', 'rapide', 'lent', 'facile', 'difficile', 'simple', 'complexe', 'nouveau', 'vieux', 'jeune', 'ancien', 'moderne', 'traditionnel', 'beau', 'laid', 'bon', 'mauvais', 'meilleur', 'pire', 'excellent', 'terrible', 'parfait', 'imparfait', 'complet', 'incomplet', 'plein', 'vide', 'ouvert', 'fermé', 'chaud', 'froid', 'tiède', 'frais', 'sec', 'humide', 'propre', 'sale', 'organisé', 'désorganisé', 'rangé', 'en désordre', 'calme', 'agité', 'paisible', 'bruyant', 'silencieux', 'fort', 'faible', 'dur', 'mou', 'rigide', 'flexible', 'solide', 'liquide', 'gazeux'],
            'phrases' => ['comment allez-vous', 'comment ça va', 'comment allez-vous', 'comment tout va', 'merci beaucoup', 'merci pour', 's\'il vous plaît', 'excusez-moi', 'pardon', 'bonjour', 'bonsoir', 'bonne nuit', 'à bientôt', 'à demain', 'quelle heure', 'quel jour', 'quel mois', 'quelle année', 'où se trouve', 'comment arriver', 'combien coûte', 'combien est', 'combien vaut', 'combien de temps', 'depuis combien de temps', 'depuis quand', 'jusqu\'à quand', 'pour combien de temps', 'pendant combien de temps', 'quand était', 'quand va', 'quand s\'est passé', 'quand va se passer', 'où est', 'où se trouve', 'où puis-je', 'où puis-je obtenir', 'où puis-je trouver', 'où puis-je acheter', 'où puis-je vendre', 'où puis-je louer', 'où puis-je réserver', 'où puis-je faire', 'où puis-je faire', 'où puis-je obtenir', 'où puis-je trouver', 'où puis-je acheter', 'où puis-je vendre', 'où puis-je louer', 'où puis-je réserver', 'où puis-je faire', 'où puis-je faire'],
        ],
        'de' => [
            'words' => ['der', 'die', 'das', 'ein', 'eine', 'einen', 'einem', 'einer', 'eines', 'von', 'vom', 'von der', 'von den', 'in', 'im', 'in der', 'in den', 'auf', 'unter', 'über', 'zwischen', 'während', 'nach', 'vor', 'wann', 'wo', 'wie', 'warum', 'was', 'wer', 'welcher', 'welche', 'welches', 'wessen', 'mein', 'meine', 'mein', 'dein', 'deine', 'dein', 'sein', 'seine', 'sein', 'ihr', 'ihre', 'ihr', 'unser', 'unsere', 'unser', 'euer', 'eure', 'euer', 'ihr', 'ihre', 'ihr', 'dieser', 'diese', 'dieses', 'jener', 'jene', 'jenes', 'ja', 'nein', 'vielleicht', 'danke', 'bitte', 'entschuldigung', 'guten morgen', 'guten tag', 'guten abend', 'gute nacht', 'hallo', 'tschüss', 'bis bald', 'bis morgen', 'heute', 'gestern', 'morgen', 'jetzt', 'nach', 'vor', 'immer', 'nie', 'manchmal', 'oft', 'selten', 'sehr', 'wenig', 'genug', 'zu', 'mehr', 'weniger', 'viel', 'wenig', 'genug', 'zu', 'mehr', 'weniger', 'groß', 'klein', 'hoch', 'niedrig', 'lang', 'kurz', 'breit', 'schmal', 'dick', 'dünn', 'schwer', 'leicht', 'schnell', 'langsam', 'einfach', 'schwer', 'einfach', 'komplex', 'neu', 'alt', 'jung', 'antik', 'modern', 'traditionell', 'schön', 'hässlich', 'gut', 'schlecht', 'besser', 'schlechter', 'ausgezeichnet', 'schrecklich', 'perfekt', 'unvollkommen', 'vollständig', 'unvollständig', 'voll', 'leer', 'offen', 'geschlossen', 'heiß', 'kalt', 'warm', 'kühl', 'trocken', 'nass', 'sauber', 'schmutzig', 'organisiert', 'unorganisiert', 'ordentlich', 'unordentlich', 'ruhig', 'aufgeregt', 'friedlich', 'laut', 'leise', 'stark', 'schwach', 'hart', 'weich', 'starr', 'flexibel', 'fest', 'flüssig', 'gasförmig'],
            'phrases' => ['wie geht es', 'wie geht es dir', 'wie geht es ihnen', 'wie geht alles', 'vielen dank', 'danke für', 'bitte', 'entschuldigung', 'entschuldigen sie', 'guten morgen', 'guten tag', 'guten abend', 'gute nacht', 'bis bald', 'bis morgen', 'wie spät', 'welcher tag', 'welcher monat', 'welches jahr', 'wo befindet sich', 'wie komme ich', 'wie viel kostet', 'wie viel ist', 'wie viel wert', 'wie lange', 'seit wann', 'bis wann', 'für wie lange', 'während wie lange', 'wann war', 'wann geht', 'wann passierte', 'wann wird passieren', 'wo ist', 'wo befindet sich', 'wo kann ich', 'wo kann ich bekommen', 'wo kann ich finden', 'wo kann ich kaufen', 'wo kann ich verkaufen', 'wo kann ich mieten', 'wo kann ich reservieren', 'wo kann ich machen', 'wo kann ich machen', 'wo kann ich bekommen', 'wo kann ich finden', 'wo kann ich kaufen', 'wo kann ich verkaufen', 'wo kann ich mieten', 'wo kann ich reservieren', 'wo kann ich machen', 'wo kann ich machen'],
        ],
        'it' => [
            'words' => ['il', 'lo', 'la', 'i', 'gli', 'le', 'un', 'uno', 'una', 'di', 'del', 'dello', 'della', 'dei', 'degli', 'delle', 'in', 'nel', 'nello', 'nella', 'nei', 'negli', 'nelle', 'su', 'sotto', 'sopra', 'tra', 'fra', 'durante', 'dopo', 'prima', 'quando', 'dove', 'come', 'perché', 'che', 'chi', 'quale', 'quali', 'cui', 'mio', 'mia', 'miei', 'mie', 'tuo', 'tua', 'tuoi', 'tue', 'suo', 'sua', 'suoi', 'sue', 'nostro', 'nostra', 'nostri', 'nostre', 'vostro', 'vostra', 'vostri', 'vostre', 'loro', 'questo', 'questa', 'questi', 'queste', 'quello', 'quella', 'quelli', 'quelle', 'sì', 'no', 'forse', 'grazie', 'per favore', 'scusi', 'mi dispiace', 'buongiorno', 'buonasera', 'buonanotte', 'ciao', 'arrivederci', 'a presto', 'a domani', 'oggi', 'ieri', 'domani', 'ora', 'dopo', 'prima', 'sempre', 'mai', 'a volte', 'spesso', 'raramente', 'molto', 'poco', 'abbastanza', 'troppo', 'più', 'meno', 'molto', 'poco', 'abbastanza', 'troppo', 'più', 'meno', 'grande', 'piccolo', 'alto', 'basso', 'lungo', 'corto', 'largo', 'stretto', 'spesso', 'sottile', 'pesante', 'leggero', 'veloce', 'lento', 'facile', 'difficile', 'semplice', 'complesso', 'nuovo', 'vecchio', 'giovane', 'antico', 'moderno', 'tradizionale', 'bello', 'brutto', 'buono', 'cattivo', 'migliore', 'peggiore', 'eccellente', 'terribile', 'perfetto', 'imperfetto', 'completo', 'incompleto', 'pieno', 'vuoto', 'aperto', 'chiuso', 'caldo', 'freddo', 'tiepido', 'fresco', 'secco', 'bagnato', 'pulito', 'sporco', 'organizzato', 'disorganizzato', 'ordinato', 'disordinato', 'calmo', 'agitato', 'pacifico', 'rumoroso', 'silenzioso', 'forte', 'debole', 'duro', 'morbido', 'rigido', 'flessibile', 'solido', 'liquido', 'gassoso'],
            'phrases' => ['come sta', 'come va', 'come sta tutto', 'grazie mille', 'grazie per', 'per favore', 'scusi', 'mi dispiace', 'buongiorno', 'buonasera', 'buonanotte', 'arrivederci', 'a presto', 'a domani', 'che ora', 'che giorno', 'che mese', 'che anno', 'dove si trova', 'come arrivare', 'quanto costa', 'quanto è', 'quanto vale', 'quanto tempo', 'da quanto tempo', 'da quando', 'fino a quando', 'per quanto tempo', 'durante quanto tempo', 'quando è stato', 'quando va', 'quando è successo', 'quando succederà', 'dove è', 'dove si trova', 'dove posso', 'dove posso ottenere', 'dove posso trovare', 'dove posso comprare', 'dove posso vendere', 'dove posso affittare', 'dove posso prenotare', 'dove posso fare', 'dove posso fare', 'dove posso ottenere', 'dove posso trovare', 'dove posso comprare', 'dove posso vendere', 'dove posso affittare', 'dove posso prenotare', 'dove posso fare', 'dove posso fare'],
        ],
    ];

    public function detectLanguage(string $message): string
    {
        $message = strtolower(trim($message));
        $scores = [];

        foreach ($this->languagePatterns as $lang => $patterns) {
            $score = 0;

            // Contar palavras comuns
            foreach ($patterns['words'] as $word) {
                if (str_contains($message, ' '.$word.' ') ||
                    str_starts_with($message, $word.' ') ||
                    str_ends_with($message, ' '.$word) ||
                    $message === $word) {
                    $score += 1;
                }
            }

            // Contar frases comuns (peso maior)
            foreach ($patterns['phrases'] as $phrase) {
                if (str_contains($message, $phrase)) {
                    $score += 3;
                }
            }

            $scores[$lang] = $score;
        }

        // Retornar o idioma com maior pontuação, ou 'en' como padrão
        $detectedLang = array_key_exists(max($scores), array_flip($scores)) ?
            array_search(max($scores), $scores) : 'en';

        return $detectedLang;
    }

    public function getConfidenceScore(string $message, string $language): float
    {
        $message = strtolower(trim($message));
        $patterns = $this->languagePatterns[$language] ?? [];

        if (empty($patterns)) {
            return 0.0;
        }

        $score = 0;
        $totalWords = str_word_count($message);

        if ($totalWords === 0) {
            return 0.0;
        }

        // Contar palavras comuns
        foreach ($patterns['words'] as $word) {
            if (str_contains($message, ' '.$word.' ') ||
                str_starts_with($message, $word.' ') ||
                str_ends_with($message, ' '.$word) ||
                $message === $word) {
                $score += 1;
            }
        }

        // Contar frases comuns (peso maior)
        foreach ($patterns['phrases'] as $phrase) {
            if (str_contains($message, $phrase)) {
                $score += 3;
            }
        }

        return min(1.0, $score / max(1, $totalWords));
    }
}
