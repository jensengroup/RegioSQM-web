
from rdkit import Chem
import sys

smiles = sys.argv[1]

m = Chem.MolFromSmiles(smiles)

if m == None:
    print 0

else:
    print 1

